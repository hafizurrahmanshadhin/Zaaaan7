<?php
    
namespace App\Services\API;

use Illuminate\Support\Facades\Auth;

class UserProfileService
{
    private $user;
    
    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function getUserProfile(){
        
    }

    public function updateAvatar() {

    }

    public function updateProfile() {

    }


}
