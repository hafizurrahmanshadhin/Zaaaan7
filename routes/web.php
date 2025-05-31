<?php

use App\Http\Controllers\Web\Auth\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.home.index');
})->name('home.index');

Route::get('/login/google', [SocialiteController::class, 'GoogleRedirect'])->name('google-login');
Route::get('/login/google/callback', [SocialiteController::class, 'GoogleCallback']);
