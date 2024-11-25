<?php

use App\Http\Controllers\API\Auth\AuthController;
use Illuminate\Support\Facades\Route;



// Define a group of routes that all use the AuthController.
Route::controller(AuthController::class)->group(function () {
    // guest route
    Route::middleware('guest:api')->group(function ($router) {
        Route::post('login', 'login')->name('login');
        Route::post('register', 'register')->name('register');
        Route::post('oto-send', 'otpSend')->name('otp-resend');
    });
    // auth routes
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', 'logout')->name('logout');
        Route::post('refresh', 'refresh')->name('refresh.token');
        Route::post('oto-send/authorized', 'otpSend')->name('otp-resend');
    });
});