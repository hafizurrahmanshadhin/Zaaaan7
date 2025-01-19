<?php

namespace App\Services\API;

use App\Models\Transaction;
use Exception;

class TransectionService
{

    public function storeTransection(array $credentials)
    {
        try {
            $transection = Transaction::create($credentials);
            return $transection;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
