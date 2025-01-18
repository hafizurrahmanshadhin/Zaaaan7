<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AvatarRequest;
use App\Http\Requests\API\UpdateHelperProfileRequest;
use App\Http\Requests\API\UpdateProfileRequest;
use App\Services\API\UserProfileService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
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
        try {
            $response = $this->userProfileService->getUserProfile();
            return $this->success(200, 'user profile', $response);
        } catch (Exception $e) {
            Log::error('UserProfileController::Show: '. $e->getMessage());
            return $this->error(500, 'failed to get user profile', $e->getMessage());
        }
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



    public function showHelper(): JsonResponse
    {
        try {
            $response = $this->userProfileService->getHelperProfile();
            return $this->success(200, 'user profile', $response);
        } catch (Exception $e) {
            Log::error('UserProfileController::Show: '. $e->getMessage());
            return $this->error(500, 'failed to get user profile', $e->getMessage());
        }
    }


    public function getHelpersBySkills($skill) {
        try {
            $response = $this->userProfileService->getHelpersBySkills($skill);
            return $this->success(200, 'helpers of the user', $response);
        } catch (Exception $e) {
            Log::error('UserProfileController::Show: '. $e->getMessage());
            return $this->error(500, 'failed to get user profile', $e->getMessage());
        }
    }


    public function showHelperById($user): JsonResponse
    {
        try {
            $response = $this->userProfileService->getHelperProfileById($user);
            return $this->success(200, 'user profile', $response);
        } catch (Exception $e) {
            Log::error('UserProfileController::Show: '. $e->getMessage());
            return $this->error(500, 'failed to get user profile', $e->getMessage());
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
            $response = $this->userProfileService->updateProfile($validatedData);
            return $this->success(200, 'profile updated successfully', $response);
        } catch (Exception $e) {
            Log::error('UserProfileController::Update: ' . $e->getMessage());
            return $this->error(500, 'profile update failed');
        }
    }





    public function updateHelper(UpdateHelperProfileRequest $updatehelperProfileRequest):JsonResponse
    {
        try {
            $validatedData = $updatehelperProfileRequest->validated();
            $response = $this->userProfileService->updateHelperProfile($validatedData);
            return $this->success(200, 'profile updated successfully', $response);
        } catch (Exception $e) {
            Log::error('UserProfileController::Update: ' . $e->getMessage());
            return $this->error(500, 'profile update failed');
        }
    }



    public function getHelper($user):JsonResponse
    {
        try {
            $response = $this->userProfileService->getHelper($user);
            return $this->success(200, 'user profile', $response);
        } catch (Exception $e) {
            Log::error('UserProfileController::Show: '. $e->getMessage());
            return $this->error(500, 'failed to get user profile', $e->getMessage());
        }
    }

}
