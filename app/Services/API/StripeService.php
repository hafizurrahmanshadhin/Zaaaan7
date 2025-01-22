<?php

namespace App\Services\API;

use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\Log;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeService
{
    public $stripeKey;
    private $stripeSecret;

    public function __construct()
    {
        $this->stripeKey = config('services.stripe.key');
        $this->stripeSecret = config('services.stripe.secret');
    }


    public function getStripeKey()
    {
        try {
            return $this->stripeKey;
        } catch (Exception $e) {
            Log::error('StripeService::getStripeKey', [$e->getMessage()]);
            throw $e;
        }
    }

    public function createPaymentIntent($credentials)
    {
        try {
            Stripe::setApiKey($this->stripeSecret);

            $task = Task::findOrFail($credentials['task_id']);

            $metadata = [
                'task_id' => $task->id,
                'client' => $task->client,
                'helper' => $task->helper,
            ];

            $paymentIntent = PaymentIntent::create([
                'amount'   => $credentials['amount'] * 100,
                'currency' => 'usd',
                'metadata' => $metadata
            ]);

            return [
                'client_secret' => $paymentIntent['client_secret'],
                'metadata' => $paymentIntent['metadata']
            ];
            // return $paymentIntent;
        } catch (Exception $e) {
            throw $e;
        }
    }


    // public function handlePaymentWebhook($credentials)
    // {
    //     try{
    //         Stripe::setApiKey($this->stripeSecret);
    //         Log::info('stripe webhook recived');

    //         $payload = $credentials
    //         return 1;
    //     }catch (Exception $e) {
    //         throw $e;
    //     }
    // }

}
