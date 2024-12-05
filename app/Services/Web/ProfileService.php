<?php

namespace App\Services\Web;

use App\Models\User;
use App\Helper\Helper;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class ProfileService
{
    protected $helper;

    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Update the user's profile information.
     * 
     * @param User $user
     * @param array $validatedData
     * @return bool
     */
    public function updateProfile(User $user, array $validatedData)
    {
        try {
            DB::beginTransaction();

            $user->update([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
            ]);

            $user->profile->update([
                'bio' => $validatedData['bio'],
                'company_name' => $validatedData['company_name'],
                'website' => $validatedData['website'],
            ]);

            DB::commit();

            return true;
        } catch (Exception $e) {
            Log::error("Profile Update Error: " . $e->getMessage());
            DB::rollBack();
            return false;
        }
    }

    /**
     * Handle avatar upload and update.
     * 
     * @param User $user
     * @param \Illuminate\Http\UploadedFile $avatar
     * @return string|false
     */
    public function updateAvatar(User $user, $avatar)
    {
        try {
            $validator = Validator::make(['avatar' => $avatar], [
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp,jfif',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $avatarPath = $this->helper->uploadFile($avatar, 'avatars/' . $user->handle, 'image');

            $user->update([
                'avatar' => $avatarPath,
            ]);

            return $avatarPath;
        } catch (ValidationException $e) {
            throw $e; // Let the controller handle validation errors
        } catch (Exception $e) {
            Log::error("Avatar Update Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete the user and log them out if necessary.
     * 
     * @param User $user
     * @return bool
     */
    public function deleteUser(User $user)
    {
        try {
            $user->delete();
            return true;
        } catch (Exception $e) {
            Log::error("User Delete Error: " . $e->getMessage());
            return false;
        }
    }
}
