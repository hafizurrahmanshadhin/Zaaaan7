<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller {
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return RedirectResponse
     */
    public function GoogleRedirect(): RedirectResponse {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->with([
                'access_type' => 'offline',
                'prompt'      => 'consent',
            ])
            ->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return JsonResponse
     */
    public function GoogleCallback(): JsonResponse {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            dd($user); // Debugging line, remove in production

            return response()->json([
                'success' => true,
                'message' => 'Token Retrieved Successfully',
                'data'    => [
                    'access_token'  => $user->token,
                    'refresh_token' => $user->refreshToken,
                    'expires_in'    => $user->expiresIn,
                ],
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
