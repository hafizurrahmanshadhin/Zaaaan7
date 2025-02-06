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

    public function getNotifications()  {
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


    public function markAsReadNotifications() {
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
}
