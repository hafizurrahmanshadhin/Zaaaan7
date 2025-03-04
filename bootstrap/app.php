<?php

use App\Helper\Helper;
use App\Http\Middleware\EnsureGuestJwt;
use App\Http\Middleware\HelperMiddleware;
use App\Http\Middleware\IsVerifyed;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api/api.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',

        // custom routes for api
        then: function () {
            // web auth
            Route::middleware(['web'])
                ->prefix('')
                ->name('')
                ->group(base_path('routes/web/auth.php'));

            Route::middleware(['web', 'auth'])
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/web/admin.php'));

            // api
            Route::middleware([])
                ->prefix('api/auth')
                ->name('api.auth.')
                ->group(base_path('routes/api/auth.php'));
        }
    )->withBroadcasting(
        __DIR__ . '/../routes/channels.php',
        [
            'prefix'     => 'api',
            'middleware' => [
                'api', 'auth.api',
            ],
        ],
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'guest.api' => EnsureGuestJwt::class,
            'helper' => HelperMiddleware::class,
            'user' => UserMiddleware::class,
            'verified' => IsVerifyed::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                // Log::info('Exception Type: ' . get_class($e));
                if ($e instanceof QueryException) {
                    return Helper::error(500, 'server error', $e->getMessage());
                }
                if ($e instanceof ModelNotFoundException) {
                    return Helper::error(404, 'not found', $e->getMessage());
                }
                if ($e instanceof AuthenticationException) {
                    return Helper::error(401, 'unauthorized', $e->getMessage());
                }
                if ($e instanceof AuthorizationException) {
                    return Helper::error(403, 'forbidden', $e->getMessage());
                }
                if ($e instanceof NotFoundHttpException) {
                    return Helper::error(404, 'not found', $e->getMessage());
                }
                if ($e instanceof MethodNotAllowedHttpException) {
                    return Helper::error(405, 'method not allowed', $e->getMessage());
                }
            }
        });
    })->create();
