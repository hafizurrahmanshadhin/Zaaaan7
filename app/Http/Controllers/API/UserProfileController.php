<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AvatarRequest;
use App\Http\Requests\API\UpdateProfileRequest;
use App\Services\API\UserProfileService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserProfileController extends Controller
{
    use ApiResponse;
    protected $userProfileService;
    public function __construct(UserProfileService $userProfileService)
    {
        $this->userProfileService = $userProfileService;
    }
    public function show()
    {
        $response = $this->userProfileService->getUserProfile();
        return $this->success(200, 'user profile', $response);
    }

    public function updateAvatar(AvatarRequest $avatarRequest)
    {
        try {
            $validatedData = $avatarRequest->validated();
            $this->userProfileService->updateAvatar($validatedData);
            return $this->success(200, 'avatar updated successfully');
        } catch (Exception $e) {
            Log::error('UserProfileController::Avatar Update: '. $e->getMessage());
            return $this->error(500, 'Avatar update failed');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $updateProfileRequest)
    {
        try {
            $validatedData = $updateProfileRequest->validated();
            $this->userProfileService->updateProfile($validatedData);
            return $this->success(200, 'avatar updated successfully');
        } catch (Exception $e) {
            Log::error('UserProfileController::Avatar Update: '. $e->getMessage());
            return $this->error(500, 'Avatar update failed');
        }
    }

}
