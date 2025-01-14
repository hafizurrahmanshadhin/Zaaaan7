<?php

namespace App\Services\API\Auth;

use App\Exceptions\OtpNotVerifiedException;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ForgerPasswordService
{
    /**
     * Reset the password for a user based on the provided credentials.
     *
     * This method attempts to reset the password for the user associated with the
     * provided email address. The new password is hashed before being saved to the
     * database. If the user does not exist or if any error occurs during the process,
     * an exception is thrown.
     *
     * @param  array  $credentials  An array containing the user's 'email' and 'password'.
     * @return bool  Returns true if the password was successfully reset, otherwise throws an exception.
     *
     * @throws \Exception  If any error occurs during the password reset process (e.g., user not found, database error).
     */
    public function resetPassword($credentials)
    {
        try {
            DB::beginTransaction();
            $email = $credentials['email'];
            $password = Hash::make($credentials['password']);
            $user = User::whereEmail($email)->first();
            $userOTP = $user->otps()->whereOperation('password')->whereStatus(false)->first();
            if (!$userOTP) {
                throw new OtpNotVerifiedException();
            }
            $user->update([
                'password' => $password,
            ]);

            $userOTP->delete();

            DB::commit();

            return true;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
