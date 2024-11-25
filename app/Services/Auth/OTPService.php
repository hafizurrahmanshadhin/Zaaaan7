<?php

namespace App\Services\Auth;

use App\Exceptions\OTPExpiredException;
use App\Exceptions\OTPMismatchException;
use App\Exceptions\UserAlreadyVarifiedException;
use App\Exceptions\UserNotFoundException;
use App\Jobs\SendOTPEmail;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OTPService
{



    /**
     * Sends an OTP (One-Time Password) to the specified user for the given operation.
     *
     * This method first retrieves the user based on their email address, deletes any existing OTPs 
     * for the specified operation, and then generates and sends a new OTP to the user. 
     * The OTP is associated with a specific operation (e.g., login, password reset).
     * If any error occurs during the process, an error is logged, and the exception is rethrown.
     *
     * @param string $email The email address of the user to whom the OTP will be sent.
     * @param string $operation The operation for which the OTP is being generated (e.g., 'login', 'password_reset').
     *
     * @return void No value is returned from this method.
     *
     * @throws Exception If there is an error retrieving the user, deleting old OTPs, or sending the new OTP.
     */
    public function otpSend($email, $operation): void
    {

        try {
            $user = User::whereEmail($email)->first();
            $user->otps()->whereOperation($operation)->delete();
            $this->otp($user, $operation);

        } catch (Exception $e) {
            Log::error('OTPService::otpSend -> ' . $e->getMessage());
            throw $e;
        }
    }



    /**
     * Verifies the OTP (One-Time Password) provided by the user for a specific operation.
     *
     * This method performs several checks to verify the OTP:
     * 1. Ensures that the user is not already verified (based on the `email_verified_at` field).
     * 2. Retrieves the user's OTP for the given operation and checks if it matches the provided OTP.
     * 3. Verifies that the OTP is not expired (expires after 1 minute).
     * 4. If the OTP is valid, it invalidates the used OTP and updates the user's verification status 
     *    (e.g., setting the `email_verified_at` field for email verification).
     * The method uses database transactions to ensure that changes are applied atomically. 
     * If an error occurs during the process, the transaction is rolled back and the exception is rethrown.
     *
     * @param string $email The email address of the user whose OTP is being verified.
     * @param string $operation The operation for which the OTP was issued (e.g., 'email' for email verification).
     * @param string $otp The OTP entered by the user to be validated.
     *
     * @return void No value is returned from this method.
     *
     * @throws UserAlreadyVarifiedException If the user is already verified.
     * @throws OTPMismatchException If the provided OTP does not match the stored OTP.
     * @throws OTPExpiredException If the OTP has expired.
     * @throws Exception If there is an error during the verification process or database operations.
     */

    public function otpMatch($email, $operation, $otp): void
    {
        try {
            $user = User::whereEmail($email)->first();

            if ($user->email_verified_at) {
                throw new UserAlreadyVarifiedException();
            }

            $userOTP = $user->otps()->whereOperation($operation)->whereStatus(true)->first();

            if (!$userOTP || (int) $otp != (int) $userOTP->number) {
                throw new OTPMismatchException();
            }

            if ($userOTP->created_at->diffInMinutes(now()) > 1) {
                throw new OTPExpiredException();
            }

            DB::beginTransaction();

            // Invalidate the OTP
            $userOTP->status = false;
            $userOTP->save();

            // Perform operation-specific logic
            if ($operation === 'email') {
                $user->email_verified_at = now();
                $user->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('OTPService::otpMatch -> ' . $e->getMessage());
            throw $e;
        }
    }




    /**
     * Generates and sends a One-Time Password (OTP) for a specific user and operation.
     *
     * This method generates a random 6-digit OTP and associates it with the provided user and operation. 
     * The OTP is saved in the database, and then an email containing the OTP is dispatched to the user 
     * using the `SendOTPEmail` job. If any error occurs during the process, the exception is logged and 
     * rethrown.
     *
     * @param User $user The user to whom the OTP will be generated and sent.
     * @param string $operation The operation for which the OTP is generated (e.g., 'email' for email verification).
     *
     * @return void No value is returned from this method.
     *
     * @throws Exception If there is an error generating or saving the OTP, or dispatching the email.
     */
    public function otp($user, $operation): void
    {
        try {
            $otp = mt_rand(111111, 999999);
            $user->otps()->create([
                'operation' => $operation,
                'number' => $otp,
            ]);

            SendOTPEmail::dispatch($user, $otp);
        } catch (Exception $e) {
            Log::error('OTPService::otpMatch -> ' . $e->getMessage());
            throw $e;
        }
    }
}