<?php

namespace App\Services\API;

use App\Helper\Helper;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserProfileService
{
    private $user;

    /**
     * Constructor to initialize the user property.
     * Retrieves the currently authenticated user using Laravel's Auth facade.
     */
    public function __construct()
    {
        $this->user = Auth::user();
    }


    /**
     * Retrieves the authenticated user's profile and related profile details.
     * 
     * This method performs the following:
     * - Selects specific columns (`id`, `first_name`, `last_name`, `email`, `avatar`) from the `users` table.
     * - Filters the user by their email.
     * - Eager loads the `profile` relationship with specific columns (`id`, `user_id`, `gender`, `phone`, `address`).
     * - Returns the first matching user record with the associated profile.
     * 
     * @return \App\Models\User|null The user with their profile data, or null if no matching user is found.
     * @throws \Exception If any error occurs during query execution.
     */
    public function getUserProfile(): mixed
    {
        try {
            $user = User::select(
                'id',
                'first_name',
                'last_name',
                'email',
                'avatar'
            )->whereEmail($this->user->email)
                ->with([
                    'profile' => function ($query) {
                        $query->select('id', 'user_id', 'gender', 'phone', 'address', 'date_of_birth');
                    }
                ])
                ->first();
            return $user;
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function getHelperProfile(): mixed
    {
        try {
            $user = User::select(
                'id',
                'first_name',
                'last_name',
                'email',
                'avatar'
            )->whereEmail($this->user->email)
                ->with([
                    'profile' => function ($query) {
                        $query->select('id', 'user_id', 'gender', 'phone', 'address', 'date_of_birth', 'bio as description');
                    }
                ])
                ->first();
            return $user;
        } catch (Exception $e) {
            throw $e;
        }
    }


    /**
     * Updates the authenticated user's avatar.
     * 
     * This method performs the following steps:
     * 1. Retrieves the current avatar URL of the authenticated user.
     * 2. Uploads the new avatar file to a specified directory using a helper function.
     * 3. Updates the `avatar` field in the user's database record with the new URL.
     * 4. Deletes the old avatar file if it exists.
     * 
     * @param array $credentials An array containing the `avatar` file to be uploaded.
     * @return void
     * @throws \Exception If any error occurs during file upload, database update, or file deletion.
     */
    public function updateAvatar($credentials): void
    {
        try {
            $userAvater = $this->user->avatar;
            $url = Helper::uploadFile($credentials['avatar'], 'user/' . $this->user->id);
            User::whereId($this->user->id)->update([
                'avatar' => $url,
            ]);
            if ($userAvater) {
                Helper::deleteFile($userAvater);
            }
        } catch (Exception $e) {
            throw $e;
        }

    }




    /**
     * Updates the authenticated user's profile and associated profile details.
     * 
     * This method performs the following steps:
     * 1. Starts a database transaction to ensure data integrity.
     * 2. Finds the authenticated user by their ID and updates their basic information:
     *    - `first_name`
     *    - `last_name`
     *    - `email`
     * 3. Updates the user's associated profile with optional values for:
     *    - `phone`
     *    - `address`
     *    - `gender`
     *    (Falls back to existing values if no new value is provided.)
     * 4. Commits the transaction upon successful updates.
     * 5. Rolls back the transaction in case of an exception and rethrows the error.
     * 
     * @param array $credentials An associative array containing updated user and profile details.
     *        Required keys: `first_name`, `last_name`, `email`.
     *        Optional keys: `phone`, `address`, `gender`.
     * @return mixed
     * @throws \Exception If any error occurs during the update process.
     */
    public function updateProfile($credentials): mixed
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($this->user->id);
            $user->update([
                'first_name' => $credentials['first_name'],
                'last_name' => $credentials['last_name'],
                'email' => $credentials['email'],
            ]);

            $user->profile()->update([
                'phone' => $credentials['phone'] ?? $user->profile->phone,
                'address' => $credentials['address'] ?? $user->profile->address,
                'gender' => $credentials['gender'] ?? $user->profile->gender,
            ]);
            DB::commit();
            return $user->load('profile');
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }



    /**
     * Update the authenticated user's profile information and associated profile details.
     * 
     * This method:
     * 1. Begins a database transaction to ensure data integrity.
     * 2. Finds the authenticated user and updates their basic information (`first_name`, `last_name`, `email`).
     * 3. Updates the user's associated profile with new or existing values for:
     *    - `phone`
     *    - `address`
     *    - `gender`
     *    - `description`
     * 4. Commits the transaction upon successful updates.
     * 5. Rolls back the transaction and throws an exception if any error occurs during the process.
     * 
     * @param array $credentials The data to update the user's profile and profile details. 
     *        Required keys: `first_name`, `last_name`, `email`.
     *        Optional keys: `phone`, `address`, `gender`, `description`.
     * @return mixed
     * @throws \Exception If any error occurs during the update process or transaction failure.
     */
    public function updateHelperProfile($credentials):mixed
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($this->user->id);
            $user->update([
                'first_name' => $credentials['first_name'],
                'last_name' => $credentials['last_name'],
                'email' => $credentials['email'],
            ]);

            $user->profile()->update([
                'phone' => $credentials['phone'] ?? $user->profile->phone,
                'address' => $credentials['address'] ?? $user->profile->address,
                'gender' => $credentials['gender'] ?? $user->profile->gender,
                'bio' => $credentials['description'] ?? $user->profile->description,
            ]);
            DB::commit();
            return $user->load('profile');
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function getHelper($id)
    {
        try {
            $user = User::with(['profile', 'skills'])->findOrFail($id);
            $user->averageRating = $user->avarageRating();
            if (!$user)
            {
                return new Exception('user not found', 404);
            }
            if ($user->role !== 'helper'){
                return new Exception('user is not a helper', 404);
            }
            return $user;
        }catch (Exception $e) {
            throw $e;
        }

    }

}
