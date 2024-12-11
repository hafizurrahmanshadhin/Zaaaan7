<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AvatarRequest;
use App\Http\Requests\API\UpdateProfileRequest;
use App\Services\API\UserProfileService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserProfileController extends Controller
{
    use ApiResponse;
    /**
     * @var UserProfileService The service for handling user profile-related operations.
     */
    protected $userProfileService;

    /**
     * Constructor.
     * 
     * Initializes the controller with the required service for user profile operations.
     * 
     * @param UserProfileService $userProfileService The user profile service instance.
     */
    public function __construct(UserProfileService $userProfileService)
    {
        $this->userProfileService = $userProfileService;
    }


    /**
     * Display the authenticated user's profile.
     * 
     * @return JsonResponse The response containing the user's profile details.
     */
    public function show(): JsonResponse
    {
        $response = $this->userProfileService->getUserProfile();
        return $this->success(200, 'user profile', $response);
    }


    /**
     * Update the authenticated user's avatar.
     * 
     * Validates the avatar request, processes the update via the service, and returns a success or error response.
     * 
     * @param AvatarRequest $avatarRequest The request containing the new avatar file.
     * @return JsonResponse The success or error response.
     */
    public function updateAvatar(AvatarRequest $avatarRequest): JsonResponse
    {
        try {
            $validatedData = $avatarRequest->validated();
            $this->userProfileService->updateAvatar($validatedData);
            return $this->success(200, 'avatar updated successfully');
        } catch (Exception $e) {
            Log::error('UserProfileController::Avatar Update: ' . $e->getMessage());
            return $this->error(500, 'Avatar update failed');
        }

    }


    /**
     * Update the authenticated user's profile information.
     * 
     * Validates the profile update request, processes the update via the service, and returns a success or error response.
     * 
     * @param UpdateProfileRequest $updateProfileRequest The request containing the updated profile data.
     * @return JsonResponse The success or error response.
     */
    public function update(UpdateProfileRequest $updateProfileRequest): JsonResponse
    {
        try {
            $validatedData = $updateProfileRequest->validated();
            $this->userProfileService->updateProfile($validatedData);
            return $this->success(200, 'avatar updated successfully');
        } catch (Exception $e) {
            Log::error('UserProfileController::Avatar Update: ' . $e->getMessage());
            return $this->error(500, 'Avatar update failed');
        }
    }

}
