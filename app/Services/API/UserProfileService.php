<?php

namespace App\Services\API;

use App\Helper\Helper;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserProfileService
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function getUserProfile()
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

    public function updateAvatar($credentials)
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

    public function updateProfile()
    {

    }

}
