<?php

namespace App\Http\Controllers\API\Auth;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Services\API\Auth\SocialLoginService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class SocialLoginController extends Controller {
    protected SocialLoginService $socialiteService;
    private Helper $helper;

    public function __construct(SocialLoginService $socialiteService, Helper $helper) {
        $this->socialiteService = $socialiteService;
        $this->helper           = $helper;
    }

    /**
     * Handle socialite login.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function socialiteLogin(Request $request): JsonResponse {
        $request->validate([
            'token'    => 'required|string',
            'provider' => 'required|string|in:google,facebook',
        ]);

        try {
            $token    = $request->input('token');
            $provider = $request->input('provider');
            $response = $this->socialiteService->loginWithSocialite($provider, $token);

            return response()->json([
                'status'     => true,
                'message'    => $response['message'],
                'code'       => $response['code'],
                'token_type' => $response['token_type'],
                'token'      => $response['token'],
                'data'       => $response['data'],
            ], $response['code']);
        } catch (UnauthorizedHttpException $e) {
            return $this->helper->jsonResponse(false, 'Unauthorized', 401, null, ['error' => $e->getMessage()]);
        } catch (Exception $e) {
            return $this->helper->jsonResponse(false, 'Something went wrong', 500, null, ['error' => $e->getMessage()]);
        }
    }
}
