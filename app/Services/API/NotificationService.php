<?php

namespace App\Services\API;

use App\Models\FirebaseToken;
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
     * @return FirebaseToken
     */
    public function storeDeviceFirebaseToken(array $credentials)
    {
        try {
            return FirebaseToken::create([
                'token' => $credentials['token'],
                'device_id' => $credentials['device_id'],
            ]);
        } catch (Exception $e) {
            Log::error('NotificationService::storeDeviceFirebaseToken', [$e->getMessage()]);
            throw $e;
        }
    }

    /**
     * getDeviceFirebaseToken
     * @return mixed
     */
    public function getDeviceFirebaseToken()
    {
        try {
            $deviceId = request('device_id');

            return FirebaseToken::whereUserId($this->user->id)
                ->whereDeviceId($deviceId)
                ->first();
        } catch (Exception $e) {
            Log::error('NotificationService::getDeviceFirebaseToken', [$e->getMessage()]);
            throw $e;
        }
    }

    /**
     * deleteDeviceFirebaseToken
     * @return void
     */
    public function deleteDeviceFirebaseToken()
    {
        try {
            $deviceId = request('device_id');
            $firebaseToken = FirebaseToken::whereUserId($this->user->id)
                ->whereDeviceId($deviceId)
                ->first();

            if ($firebaseToken) {
                $firebaseToken->delete();
            }
        } catch (Exception $e) {
            Log::error('NotificationService::deleteDeviceFirebaseToken', [$e->getMessage()]);
            throw $e;
        }
    }
}
