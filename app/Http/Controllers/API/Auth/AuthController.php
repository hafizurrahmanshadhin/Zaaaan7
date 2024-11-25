<?php

namespace App\Http\Controllers\API\Auth;

use App\Exceptions\OTPExpiredException;
use App\Exceptions\OTPMismatchException;
use App\Exceptions\UserAlreadyVarifiedException;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\Auth\OTPRequest;
use App\Services\Auth\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\OTPMatchRequest;
use App\Http\Requests\Auth\PasswordChangeRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\OTPService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use ApiResponse;


    protected AuthService $authService;

    /**
     * Class constructor that initializes the AuthService dependency.
     * 
     * This constructor accepts an instance of the AuthService and binds it to the 
     * class property. It allows access to authentication-related methods throughout 
     * the class, enabling operations such as user registration, login, and token management.
     *
     * @param AuthService $authService The AuthService instance used for authentication tasks.
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }



    /**
     * Handles the user registration process by validating the request and delegating
     * the registration logic to the AuthService.
     * 
     * This method first validates the incoming registration data using the provided 
     * RegisterRequest. If validation passes, it calls the AuthService to register 
     * the user and generate a JWT token. Upon success, it returns a success response 
     * with the generated token. If an error occurs during the registration process, 
     * it returns an error response with the appropriate message.
     *
     * @param RegisterRequest $request The validated registration request containing user data:
     *                                 - 'name' (string): The user's full name.
     *                                 - 'email' (string): The user's email address.
     *                                 - 'password' (string): The user's password.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response with the registration result:
     *                                      - On success: Returns the JWT token and a success message.
     *                                      - On failure: Returns the error message.
     * 
     * @throws Exception If any error occurs during user registration.
     */
    public function register(RegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $token = $this->authService->register($validatedData);

            return $this->success(200, 'user registration successfull', ['token' => $token]);

        } catch (Exception $e) {
            Log::error('User registration' . $e->getMessage());
            return $this->error(500, 'server error', $e->getMessage());
        }

    }



    /**
     * Handles the user login process by validating the request and delegating
     * the authentication logic to the AuthService.
     * 
     * This method validates the incoming login credentials using the provided 
     * LoginRequest. If validation passes, it calls the AuthService to authenticate 
     * the user and generate a JWT token. Upon success, it returns a success response 
     * with the generated token. If validation fails or any error occurs during 
     * the login process, it returns an error response with the appropriate message.
     *
     * @param LoginRequest $request The validated login request containing user credentials:
     *                              - 'email' (string): The user's email address.
     *                              - 'password' (string): The user's password.
     *
     * @return JsonResponse A JSON response with the login result:
     *                     - On success: Returns the JWT token and a success message.
     *                     - On validation failure: Returns validation errors and a failure message.
     *                     - On general failure: Returns the error message and a failure status.
     * 
     * @throws ValidationException If the validation of the login credentials fails.
     * @throws Exception If any other error occurs during user login.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $token = $this->authService->login($validatedData);

            return $this->success(200, 'user login successfull', ['token' => $token]);
        } catch (Exception $e) {
            Log::error('User login' . $e->getMessage());
            return $this->error(500, 'server error', $e->getMessage());
        }
    }




    /**
     * Logs out the authenticated user by invalidating the current JWT token.
     * 
     * This method retrieves the current JWT token from the request, invalidates it, 
     * and effectively logs the user out. Upon successful logout, it returns a success 
     * response. If an error occurs during the logout process (e.g., invalid token), 
     * an error response is returned with the appropriate message.
     *
     * @return JsonResponse A JSON response with the logout result:
     *                     - On success: Returns a success message confirming the user was logged out.
     *                     - On failure: Returns the error message and a failure status.
     * 
     * @throws Exception If any error occurs during the logout process, such as an invalid token.
     */
    public function logout(): JsonResponse
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::invalidate($token);
            return $this->success(200, 'user logged out successfully', ['token' => $token]);
        } catch (Exception $e) {
            Log::error('User logout' . $e->getMessage());
            return $this->error(500, 'server error', $e->getMessage());
        }
    }




    /**
     * Refreshes the JWT token for the authenticated user.
     * 
     * This method attempts to refresh the current JWT token, generating a new token
     * for the user. If the refresh is successful, it returns the new token in the 
     * response. If an error occurs during the token refresh process (e.g., invalid or 
     * expired token), an error response is returned indicating the failure.
     *
     * @return JsonResponse A JSON response with the result of the token refresh:
     *                     - On success: Returns the new JWT token and a success message.
     *                     - On failure: Returns an error message indicating the failure to refresh the token.
     * 
     * @throws JWTException If the token could not be refreshed (e.g., invalid or expired token).
     */
    public function refresh(): JsonResponse
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());
            return $this->success(200, 'token updated', ['token' => $token]);
        } catch (Exception $e) {
            Log::error('User refresh token' . $e->getMessage());
            return $this->error(500, 'server error', $e->getMessage());
        }
    }





    /**
     * Sends an OTP (One-Time Password) to the provided email address based on the requested operation.
     *
     * This method handles the process of generating and sending an OTP via email. It utilizes
     * the OTPService to perform the sending operation. If the OTP is successfully sent, a 
     * success response is returned. In case of an exception or failure, an error response is 
     * generated with relevant information.
     *
     * @param OTPRequest $request The request containing the email address and operation details.
     *                            - email: The recipient's email address.
     *                            - operation: The type of operation that the OTP is being sent for.
     *
     * @return JsonResponse A JSON response indicating the success or failure of the OTP sending operation.
     *                       - 200: Success with message 'otp sended'.
     *                       - 500: Server error with exception details.
     *
     * @throws Exception If there is an error in sending the OTP.
     */
    public function otpSend(OTPRequest $request): JsonResponse
    {
        try {
            $otpService = new OTPService();
            $otpService->otpSend($request->email, $request->operation);
            return $this->success(200, 'otp sended', []);
        } catch (Exception $e) {
            Log::error('Send OTP' . $e->getMessage());
            return $this->error(500, 'server error', $e->getMessage());
        }
    }



    /**
     * Verifies the OTP (One-Time Password) provided by the user for a given email and operation.
     *
     * This method checks if the provided OTP matches the one sent to the user's email for 
     * a specific operation. It utilizes the OTPService to perform the matching operation. 
     * Based on the outcome, the appropriate response is returned:
     * - If the OTP is verified successfully, a success response is returned.
     * - If the OTP does not match, is expired, or if the user has already been verified, 
     *   a corresponding error response is returned.
     *
     * @param OTPMatchRequest $request The request containing the email address, operation details,
     *                                 and OTP to be verified.
     *                                 - email: The recipient's email address.
     *                                 - operation: The operation for which the OTP was issued.
     *                                 - otp: The OTP to be verified.
     *
     * @return JsonResponse A JSON response indicating the success or failure of the OTP verification.
     *                       - 200: OTP verified successfully.
     *                       - 400: User is already verified.
     *                       - 400: OTP did not match.
     *                       - 400: OTP has expired.
     *                       - 500: Server error with exception details.
     *
     * @throws UserAlreadyVarifiedException If the user is already verified.
     * @throws OTPMismatchException If the OTP does not match.
     * @throws OTPExpiredException If the OTP has expired.
     * @throws Exception If a general error occurs during the verification process.
     */
    public function otpMatch(OTPMatchRequest $request): JsonResponse
    {
        try {
            $otpService = new OTPService();
            $otpService->otpMatch($request->email, $request->operation, $request->otp);
            return $this->success(200, 'otp verified', []);
        } catch (UserAlreadyVarifiedException $e) {
            Log::error('OTP Match: ' . $e->getMessage());
            return $this->error($e->getCode(), 'User is already verified', $e->getMessage());
        } catch (OTPMismatchException $e) {
            Log::error('OTP Match: ' . $e->getMessage());
            return $this->error($e->getCode(), 'OTP did not match', $e->getMessage());
        } catch (OTPExpiredException $e) {
            Log::error('OTP Match: ' . $e->getMessage());
            return $this->error($e->getCode(), 'OTP Expired', $e->getMessage());
        } catch (Exception $e) {
            Log::error('OTP Match: ' . $e->getMessage());
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }


    /**
     * Changes the password for the specified user.
     *
     * This method allows a user to change their password. It leverages the `authService` to 
     * update the password for the given email. If the password change is successful, 
     * a success response is returned. In case of any error during the process, a server error 
     * response is returned with the exception details.
     *
     * @param PasswordChangeRequest $request The request containing the user's email and the new password.
     *                                        - email: The user's email address.
     *                                        - password: The new password to be set.
     *
     * @return JsonResponse A JSON response indicating the result of the password change operation.
     *                       - 200: Password changed successfully.
     *                       - 500: Server error with exception details.
     *
     * @throws Exception If there is an error during the password change process.
     */
    public function changePassword(PasswordChangeRequest $request): JsonResponse
    {
        try {
            $this->authService->changePassword($request->email, $request->password);
            return $this->success(200, 'password changed successfully', []);
        } catch (Exception $e) {
            Log::error('Change Password' . $e->getMessage());
            return $this->error(500, 'server error', $e->getMessage());
        }
    }
}