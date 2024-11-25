<?php

namespace App\Services\Auth;

use App\Jobs\SendOTPEmail;
use App\Models\User;
use Exception;
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
     * @return string Returns '200' on success or an error message on failure.
     */
    public function otpSend($email, $operation): string
    {

        try {
            $user = User::whereEmail($email)->first();
            $user->otps()->whereOperation($operation)->delete();
            $this->otp($user, $operation);
            return '200';

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $e;
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
     * @return void
     */
    public function otp($user, $operation)
    {
        $otp = mt_rand(111111, 999999);
        $user->otps()->create([
            'operation' => $operation,
            'number' => $otp,
        ]);
        // quejob
        SendOTPEmail::dispatch($user, $otp);
    }
}