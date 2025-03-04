<?php

namespace App\Traits;

use Exception;
use Google\Auth\ApplicationDefaultCredentials;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Google\Auth\Credentials\ServiceAccountCredentials;

trait PushNotification
{

    private function getMessaging()
    {
        $factory = (new Factory)->withServiceAccount(config('firebase.credentials'));
        return $factory->createMessaging();
    }

    public function sendPushNotification(string $token, string $title, string $body, array $data = [])
    {
        try {
            $messaging = $this->getMessaging();
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification(Notification::create($title, $body))
                ->withData($data);

            $messaging->send($message);
            Log::info("Push notification sent to $token");
        } catch (Exception $e) {
            Log::error("Push notification error: " . $e->getMessage());
        }
    }
}
