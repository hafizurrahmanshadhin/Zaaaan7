<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreTransectionRequest;
use App\Services\API\TransectionService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransectionController extends Controller
{
    use ApiResponse;
    protected TransectionService $transectionService;

    public function __construct(TransectionService $transectionService)
    {
        $this->transectionService = $transectionService;
    }

    public function store(StoreTransectionRequest $storeTransectionRequest)
    {
        try {
            $response = $this->transectionService->storeTransection($storeTransectionRequest);
            return $this->success(200, 'success', $response);
        }catch(Exception $e) {
            Log::error('TransectionController::store', [$e->getMessage()]);
            return $this->error(500, 'server error', $e->getMessage());
        }
    }
}
