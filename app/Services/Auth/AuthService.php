<?php

namespace App\Services\Auth;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
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
            User::create([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password'])
            ]);

            $token = $token = JWTAuth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']]);

            if (!$token) {
                throw new Exception('Token generation failed.');
            }

            return $token;

        } catch (Exception $e) {
            Log::error('AuthService::register -> ' . $e->getMessage());
            return null;
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
     * @throws ValidationException If the password is incorrect or the user is not found.
     * @throws Exception If any other error occurs, such as token generation failure.
     */
    public function login(array $credentials): string
    {
        try {
            $user = User::where('email', $credentials['email'])->first();

            // Validate password
            if (!Hash::check($credentials['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'password' => ['The provided password is incorrect.']
                ]);
            }

            $token = JWTAuth::fromUser($user);

            if (!$token) {
                throw new Exception('Token generation failed.');
            }

            return $token;

        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('AuthService::login -> ' . $e->getMessage());
            throw new Exception('An error occurred while processing the login.');
        }

    }
}