<?php

namespace App\Services\API;

use Exception;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }
    public function show():array
    {
        try {
            return [
                'totalEarn' => 0.0,
                'weeklyEarn' => 0.0,
                'rating' =>  $this->user->avarageRating(),
            ];
        }catch(Exception $e) {
            throw $e;
        }
    }
}
