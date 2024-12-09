<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Requests\API\Auth\RegisterHelperRequest;
use App\Services\Auth\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Traits\ApiResponse;
use Exception;
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
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $response = $this->authService->register($validatedData);

            return $this->success(200, 'user registration successfull', $response);

        } catch (Exception $e) {
            Log::error('User registration' . $e->getMessage());
            return $this->error(500, 'server error', $e->getMessage());
        }

    }



    /**
     * Handles the registration of a new helper user.
     * 
     * This method:
     * - Validates the incoming request data using the `RegisterHelperRequest` validation rules.
     * - Passes the validated data to the `AuthService` to register the user.
     * - Returns a successful JSON response with the user registration details.
     * - Catches and logs any exceptions during the registration process, returning a server error response.
     * 
     * @param RegisterHelperRequest $registerHelperRequest The validated request containing the user credentials:
     *   - first_name: The user's first name.
     *   - last_name: The user's last name.
     *   - email: The user's email address.
     *   - password: The user's password.
     *   - description: The user's profile description (bio).
     *   - id: The user's ID document file.
     *   - documents: An array of additional document files to be uploaded.
     *   - sub_category_id: The ID of the skill sub-category to attach to the user.
     * 
     * @return JsonResponse A JSON response containing:
     *   - A status code (200 for success or 500 for error).
     *   - A message indicating success or failure.
     *   - The response data (on success), which contains the JWT token, user role, and email verification flag.
     * 
     * @throws Exception If any error occurs during the registration process, such as validation failure, 
     *                   user creation failure, or external service issues (e.g., OTP sending or token generation).
     */
    public function registerHelper(RegisterHelperRequest $registerHelperRequest): JsonResponse
    {
        try {
            $validatedData = $registerHelperRequest->validated();
            $response = $this->authService->registerHelper($validatedData);

            return $this->success(200, 'user registration successfull', $response);

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

            $response = $this->authService->login($validatedData);

            return $this->success(200, 'user login successfull', $response);
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
            $this->authService->logout();
            return $this->success(200, 'user logged out successfully');
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

}