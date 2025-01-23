<?php

namespace App\Services\API;

use App\Models\Task;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\Webhook;
use UnexpectedValueException;

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


    public function handlePaymentWebhook($request): mixed
    {
        try {
            Stripe::setApiKey($this->stripeSecret);
            Log::info('Stripe webhook received');

            $payload = $request->getContent();
            $sigHeader = $request->header('Stripe-Signature');
            $endpointSecret = config('services.stripe.webhook_secret');

            // Verify webhook signature
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);

            // Handle the event
            $eventType = $event->type;
            $paymentIntent = $event->data->object;

            switch ($eventType) {
                case 'payment_intent.succeeded':
                    $this->handlePayment($paymentIntent, 'succeeded');
                    break;

                case 'payment_intent.payment_failed':
                    $this->handlePayment($paymentIntent, 'failed');
                    break;

                default:
                    // Log::warning("Unhandled Stripe event type: $eventType", ['event' => $event]);
                    $this->handlePayment($paymentIntent, 'failed');
                    break;
            }

            return true;
        } catch (UnexpectedValueException | SignatureVerificationException $e) {
            Log::error('Stripe webhook validation error', [
                'error' => $e->getMessage(),
                'payload' => $payload ?? null,
                'signature' => $sigHeader ?? null,
            ]);
            throw $e;
        } catch (Exception $e) {
            Log::error('Stripe webhook handling error', [$e->getMessage()]);
            throw $e;
        }
    }

    protected function handlePayment($paymentIntent, $status)
    {
        try {
            // Extract metadata
            $task_id = $paymentIntent->metadata->task_id ?? null;
            $client_id = $paymentIntent->metadata->client ?? null;
            $helper_id = $paymentIntent->metadata->helper ?? null;
            $amount = $paymentIntent->amount / 100;

            // Ensure metadata is valid
            if (!$task_id || !$client_id || !$helper_id) {
                throw new Exception('Missing required metadata in payment intent');
            }

            // Avoid duplicate transactions
            if (Transaction::where('transaction_id', $paymentIntent->id)->exists()) {
                Log::info('Duplicate transaction detected', ['transaction_id' => $paymentIntent->id]);
                return;
            }

            // Save transaction
            Transaction::create([
                'transaction_id' => $paymentIntent->id,
                'task_id' => $task_id,
                'client' => $client_id,
                'helper' => $helper_id,
                'amount' => $amount,
                'status' => $status
            ]);
        } catch (Exception $e) {
            Log::error('Error in handlePayment', [$e->getMessage()]);
            throw $e;
        }
    }

}
