<?php

use App\Http\Controllers\Web\Backend\CateogryController;
use App\Http\Controllers\Web\Backend\HomeController;
use App\Http\Controllers\Web\Backend\Setting\MailController;
use App\Http\Controllers\Web\Backend\SubCateogryController;
use App\Http\Controllers\Web\Backend\ProfileController;
use Illuminate\Support\Facades\Route;


Route::prefix('/')->name('home.')->controller(HomeController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });


Route::prefix('/category')->name('category.')->group(function () {

    Route::prefix('/')->name('')->controller(CateogryController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('//{category}', 'edit')->name('edit');
            Route::put('/update/{category}', 'update')->name('update');
            Route::delete('/destroy/{category}', 'destroy')->name('destroy');
        });

    Route::prefix('/{category}/sub-cateogry')->name('sub.')->controller(SubCateogryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{subCategory}', 'edit')->name('edit');
        Route::put('/update/{subCategory}', 'update')->name('update');
    });
});

Route::prefix('sub-cateogry')->name('sub.')->controller(SubCateogryController::class)->group(function () {
    Route::delete('/destroy/{subCategory}', 'destroy')->name('destroy');
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