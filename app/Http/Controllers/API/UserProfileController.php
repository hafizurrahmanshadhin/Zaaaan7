<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\UserProfileService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

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
        $response =  $this->userProfileService->getUserProfile();
        return $this->success(200, 'user profile',$response);
    }

    public function updateAvatar()
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

}
