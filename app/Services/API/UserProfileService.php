<?php

namespace App\Services\API;

use App\Models\User;
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
    }

    public function updateAvatar()
    {

    }

    public function updateProfile()
    {

    }

}
