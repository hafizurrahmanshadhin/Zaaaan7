<?php
    
namespace App\Services\API;

use App\Helper\Helper;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HelperProfileService
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


    public function getUserProfile():mixed
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
                        $query->select('id', 'user_id', 'gender', 'phone', 'address');
                    }
                ])
                ->first();
            return $user;
        } catch (Exception $e) {
            throw $e;
        }

    }


    public function updateAvatar($credentials):void
    {
        try {
            $userAvater = $this->user->avatar;
            $url = Helper::uploadFile($credentials['avatar'], 'user/' . $this->user->id . '/');
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



    public function updateProfile($credentials):void
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
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
