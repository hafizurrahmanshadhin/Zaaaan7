<?php

namespace App\Services\Auth;

use App\Jobs\SendOTPEmail;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthService
{

    /**
     * Registers a new user and returns a JWT token upon successful registration.
     * 
     * This method accepts user credentials, creates a new user record in the database,
     * and generates a JWT token for authentication if the user is successfully registered.
     * In case of an error during user creation or token generation, an exception is caught,
     * logged, and the method returns null to indicate failure.
     *
     * @param array $credentials An associative array containing the user's registration details:
     *                            - 'name' (string): The full name of the user.
     *                            - 'email' (string): The email address of the user.
     *                            - 'password' (string): The plain-text password of the user, which will be hashed.
     * 
     * @return string|null The generated JWT token if registration is successful; otherwise, null if an error occurs.
     * 
     * @throws Exception If token generation fails after user creation.
     */
    public function register(array $credentials): string
    {
        try {
            DB::beginTransaction();
            // creating user
            $user = User::create([
                'first_name' => $credentials['first_name'],
                'last_name' => $credentials['last_name'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password']),

            ]);
            // creating user profile
            $user->profile()->create([
                'address' => $credentials['address'],
            ]);

            // creating a otp
            // $otp = mt_rand(111111,999999);
            // $user->otps()->create([
            //     'operation' => 'email',
            //     'number' => $otp,
            // ]);

            // SendOTPEmail::dispatch($user, $otp);
            // Mail::to($user->email)->send(new OTPMail('Onboarding', $otp, $user));

            $optService = new OTPService();
            $optService->otpSend($user->email, 'email');


            $token = $token = JWTAuth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']]);

            if (!$token) {
                throw new Exception('Token generation failed.');
            }
            DB::commit();

            return $token;

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('AuthService::register -> ' . $e->getMessage());
            throw $e;
        }

    }


    /**
     * Authenticates a user and returns a JWT token upon successful login.
     * 
     * This method accepts user credentials, verifies the user's existence, and checks the 
     * provided password against the stored hash. If authentication is successful, a JWT token
     * is generated for the user. If any error occurs during the process, an appropriate exception
     * is thrown with a detailed error message.
     *
     * @param array $credentials An associative array containing the user's login credentials:
     *                            - 'email' (string): The email address of the user.
     *                            - 'password' (string): The plain-text password of the user.
     *
     * @return string The generated JWT token if the login is successful.
     * 
     * @throws Exception If any other error occurs, such as token generation failure.
     */
    public function login(array $credentials): string
    {
        try {
            $user = User::where('email', $credentials['email'])->first();

            $token = JWTAuth::fromUser($user);

            if (!$token) {
                throw new Exception('Token generation failed.');
            }

            return $token;

        } catch (Exception $e) {
            Log::error('AuthService::login -> ' . $e->getMessage());
            throw $e;
        }
    }



    /**
     * Changes the password for the user identified by the provided email.
     *
     * This method retrieves the user based on the given email and updates their password
     * with the new one provided. The password is hashed using the `Hash::make` function
     * before being saved in the database. If the operation is successful, it returns a 
     * success status. In case of any exception during the process, an error is logged 
     * and the exception is rethrown.
     *
     * @param string $email The email address of the user whose password is being changed.
     * @param string $password The new password to set for the user.
     *
     * @return string Returns '200' if the password is successfully changed.
     *
     * @throws Exception If there is an error while fetching the user or updating the password.
     */
    public function changePassword($email, $password)
    {
        try {
            $user = User::where('email', $email)->first();
            $user->update([
                'password' => Hash::make($password),
            ]);
            return '200';
        } catch (Exception $e) {
            Log::error('AuthService::changepassword -> ' . $e->getMessage());
            throw $e;
        }
    }
}