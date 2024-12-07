<?php

use App\Http\Controllers\Web\Backend\HomeController;
use App\Http\Controllers\Web\Backend\Setting\MailController;
use App\Http\Controllers\Web\ProfileController;
use Illuminate\Support\Facades\Route;


Route::prefix('/')->name('home.')->controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});


// Routes for managing dates in the admin panel.
// This includes viewing, creating, editing, and deleting dates.
Route::prefix('setting/mail')->name('setting.mail.')->controller(MailController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
});

Route::prefix('/profile')->name('profile.')->controller(ProfileController::class)->group(function () {
    Route::get('/', 'edit')->name('edit');
    Route::patch('/', 'update')->name('update');
    Route::post('/avatar', 'avatar')->name('avatar');
    Route::get('/destroy/{user}', 'destroy')->name('destroy')->middleware('password.confirm');
});