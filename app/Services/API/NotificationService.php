<?php

namespace App\Services\API;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function getNotifications()
    {
        try {
            return $this->user->unreadNotifications->map(function ($notification) {
                $notification->time = Carbon::parse($notification->created_at)->diffForHumans();
                return $notification;
            });
        } catch (Exception $e) {
            Log::error('NotificationService::getNotifications', [$e->getMessage()]);
            throw $e;
        }
    }


    public function markAsReadNotifications()
    {
        try {
            $unreadNotifications = $this->user->unreadNotifications;
            foreach ($unreadNotifications as $notification) {
                $notification->markAsRead();
            }
        } catch (Exception $e) {
            Log::error('NotificationService::getNotifications', [$e->getMessage()]);
            throw $e;
        }
    }


    /**
     * storeDeviceFirebaseToken
     * @param array $credentials
     * @return void
     */
    public function storeDeviceFirebaseToken(array $credentials)
    {
        try {
        } catch (Exception $e) {
            Log::error('NotificationService::storeDeviceFirebaseToken', [$e->getMessage()]);
            throw $e;
        }
    }

    /**
     * getDeviceFirebaseToken
     * @param array $credentials
     * @return void
     */
    public function getDeviceFirebaseToken(array $credentials)
    {
        try {
        } catch (Exception $e) {
            Log::error('NotificationService::getDeviceFirebaseToken', [$e->getMessage()]);
            throw $e;
        }
    }

    /**
     * deleteDeviceFirebaseToken
     * @param array $credentials
     * @return void
     */
    public function deleteDeviceFirebaseToken(array $credentials)
    {
        try {
        } catch (Exception $e) {
            Log::error('NotificationService::deleteDeviceFirebaseToken', [$e->getMessage()]);
            throw $e;
        }
    }
}
