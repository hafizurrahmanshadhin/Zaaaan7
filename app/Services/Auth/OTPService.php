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
     * Sends an OTP to the user and handles associated operations.
     *
     * This method deletes any existing OTPs for the specified user and operation,
     * generates a new OTP, and dispatches an email job to send the OTP to the user.
     * It uses relationships to handle OTP operations for the user.
     *
     * @param string $email The email address of the user.
     * @param string $operation The operation associated with the OTP (e.g., 'email').
     *
     * @return void Returns '200' on success or an error message on failure.
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
     * Match an OTP for a given email and operation.
     *

     * @param string $email     The email address of the user.
     * @param string $operation The operation type (e.g., 'email', 'reset').
     * @param string $otp       The OTP to validate.
     *
     * @return void          
     */
    public function otpMatch($email, $operation, $otp): void
    {
        try {
            $user = User::whereEmail($email)->first();

            if ($user->email_verified_at){
                throw new UserAlreadyVarifiedException();
            }
            
            $userOTP = $user->otps()->whereOperation($operation)->whereStatus(true)->first();

            if (!$userOTP || (int)$otp != (int)$userOTP->number) {
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
            throw  $e;
        }
    }




    /**
     * Generates and sends a new OTP to the user.
     *
     * This method creates a new OTP for the user and associates it with the specified operation.
     * It then dispatches a job to send the OTP via email.
     *
     * @param User $user The user instance for whom the OTP is generated.
     * @param string $operation The operation associated with the OTP (e.g., 'email').
     *
     */
    public function otp($user, $operation):void
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
            throw  $e;
        }
    }
}