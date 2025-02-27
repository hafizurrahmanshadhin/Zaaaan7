<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreFirebaseToken;
use App\Services\API\NotificationService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    use ApiResponse;
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $response = $this->notificationService->getNotifications();
            return $this->success(200, 'all notifications', $response);
        } catch (Exception $e) {
            Log::error('NotificationController::index', [$e->getMessage()]);
            return $this->error(500, 'server error', $e->getMessage());
        }
    }


    /**
     * read
     * @return \Illuminate\Http\JsonResponse
     */
    public function read()
    {
        try {
            $this->notificationService->markAsReadNotifications();
            return $this->success(200, 'marked as read');
        } catch (Exception $e) {
            Log::error('NotificationController::read', [$e->getMessage()]);
            return $this->error(500, 'server error', $e->getMessage());
        }
    }

    /**
     * Summary of storeToken
     * @param \App\Http\Requests\API\StoreFirebaseToken $storeFirebaseToken
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeToken(StoreFirebaseToken $storeFirebaseToken): JsonResponse
    {
        try {
            $validatedData = $storeFirebaseToken->validated();
            $response = $this->notificationService->storeDeviceFirebaseToken($validatedData);
            return $this->success(200, 'token saved successfully', $response);
        } catch (Exception $e) {
            Log::error('NotificationController::storeToken', [$e->getMessage()]);
            return $this->error(500, 'server error', $e->getMessage());
        }
    }


    public function getToken()
    {
        try {

        } catch (Exception $e) {
            Log::error('NotificationController::storeToken', [$e->getMessage()]);
            return $this->error(500, 'server error', $e->getMessage());
        }
    }

    public function deleteToken()
    {
        try {

        } catch (Exception $e) {
            Log::error('NotificationController::storeToken', [$e->getMessage()]);
            return $this->error(500, 'server error', $e->getMessage());
        }
    }
}
