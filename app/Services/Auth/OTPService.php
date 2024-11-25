<?php

namespace App\Services\Auth;

use App\Traits\ApiResponse;

class OTPService 
{
    use ApiResponse;

    public function otoSend($email , $operation) : string
    {
        return '';
    }
}