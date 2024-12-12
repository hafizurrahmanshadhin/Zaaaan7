<?php

namespace App\Services\API;

use Illuminate\Support\Facades\Auth;

class AddressService
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function getAddresses()
    {

    }

    public function storeAddress(array $credentials)
    {

    }
}
