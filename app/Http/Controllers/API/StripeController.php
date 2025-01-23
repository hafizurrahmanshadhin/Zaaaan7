<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StripeCreatePaymentRequest;
use App\Http\Requests\StripeWebhookRequest;
use App\Services\API\StripeService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
    use ApiResponse;
    protected StripeService $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function createPayent(StripeCreatePaymentRequest $stripeCreatePaymentRequest):JsonResponse
    {
        try {
            $validatedData = $stripeCreatePaymentRequest->validated();
            $response = $this->stripeService->createPaymentIntent($validatedData);
            return $this->success(200, 'success', $response);
        } catch (Exception $e) {
            Log::error("StripeController::createPayent", [$e->getMessage()]);
            return $this->error( 500, 'server error', $e->getMessage());
        }
    }


    public function paymentWebhook(Request $request):JsonResponse
    {
        try {
            $response = $this->stripeService->handlePaymentWebhook($request);
            return $this->success(200, 'webhook called', $response);
        } catch (Exception $e) {
            Log::error("paymentWebhook::createPayent", [$e->getMessage()]);
            return $this->error( 500, 'server error', $e->getMessage());
        }
    }
}
