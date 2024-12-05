<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\UpdateProfileRequest;
use App\Models\User;
use App\Services\Web\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    protected $profileService;
    protected $user;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
        $this->user = Auth::user();
    }

    /**
     * Show the form for editing the specified user's profile.
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile;

        return view('backend.layouts.profile.edit', compact('user', 'profile'));
    }

    /**
     * Update the specified user's profile information in storage.
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProfileRequest $request)
    {
        $validatedData = $request->validated();
        $isUpdated = $this->profileService->updateProfile($this->user, $validatedData);

        if ($isUpdated) {
            return redirect()->back()->with('success', 'Profile updated successfully');
        } else {
            return redirect()->back()->with('error', 'An error occurred while updating your profile');
        }
    }

    /**
     * Upload and update the user's avatar image.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function avatar(Request $request)
    {
        try {
            $avatar = $request->file('avatar');
            $avatarPath = $this->profileService->updateAvatar($this->user, $avatar);

            if ($avatarPath) {
                return response()->json([
                    'success' => true,
                    'data' => $avatarPath,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while uploading the avatar',
                ], 500);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors(),
                'message' => "Validation failed",
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again.',
            ], 500);
        }
    }

    public function destroy(Request $request, User $user)
    {
    }
}
