<?php

namespace App\Http\Controllers\API\Auth;

use App\Exceptions\OtpNotVerifiedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\ForgetPasswordResetRequest;
use App\Http\Requests\API\Auth\OTPRequest;
use App\Services\API\Auth\ForgerPasswordService;
use App\Services\API\Auth\OTPService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ForgerPasswordController extends Controller
{
    use ApiResponse;

    protected ForgerPasswordService $forgerPasswordService;

    public function __construct(ForgerPasswordService $forgerPasswordService)
    {
        $this->forgerPasswordService = $forgerPasswordService;
    }


    /**
     * Reset the user's password based on the provided credentials.
     *
     * This method validates the incoming request for the password reset (e.g., email and new password).
     * If the reset process is successful, a success response is returned. If there is an issue
     * during the process (e.g., failure in the service layer), an exception is thrown and logged.
     *
     * @param  ForgetPasswordResetRequest  $forgetPasswordResetRequest  The validated request containing 'email' and 'password' for the reset.
     * @return JsonResponse  A JSON response indicating success or failure of the password reset operation.
     *
     * @throws Exception  If any error occurs during the password reset process (e.g., failure in the service layer).
     */
    public function resetPassword(ForgetPasswordResetRequest $forgetPasswordResetRequest):JsonResponse
    {
        try {
            $validatedData = $forgetPasswordResetRequest->validated();
            $response = $this->forgerPasswordService->resetPassword($validatedData);
            if ($response) {
                return $this->success(200, 'password reset successfull');
            }
            throw new Exception('server error', 500);
        }catch(OtpNotVerifiedException $e){
            return $this->error(500, 'otp not verified', $e->getMessage());
        }
        catch (Exception $e) {
            Log::error('ForgerPasswordController::resetPassword: ' . $e->getMessage());
            return $this->error(500, 'server error', $e->getMessage());
        }
    }
}
