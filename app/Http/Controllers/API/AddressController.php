<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateAddressRequest;
use App\Models\Address;
use App\Services\API\AddressService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    use ApiResponse;
    private AddressService $addressService;

    public function __construct()
    {
        $this->addressService = new AddressService;
    }

    public function index(): JsonResponse
    {
        try {
            return $this->success(200, '', '');
        } catch (Exception $e) {
            Log::error('AddressController::index:' . $e->getMessage());
            return $this->error(500, 'fail to fetch addressed', $e->getMessage());
        }
    }

    public function store(CreateAddressRequest $createAddressRequest): JsonResponse
    {
        try {
            return $this->success(200, '', '');
        } catch (Exception $e) {
            Log::error('AddressController::store:' . $e->getMessage());
            return $this->error(500, 'fail to store address', $e->getMessage());
        }
    }

    public function delete(Address $address): JsonResponse
    {
        try {
            return $this->success(200, '', '');
        } catch (Exception $e) {
            Log::error('AddressController::delete:' . $e->getMessage());
            return $this->error(500, 'fail to delete address', $e->getMessage());
        }
    }

}
