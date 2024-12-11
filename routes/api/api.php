<?php

use App\Helper\Helper;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\UserProfileController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;



Route::prefix('category')->name('category.')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{category}', 'view')->name('view');
    Route::get('/sub-category/{category}', 'subCategories')->name('sub.category');
});


Route::middleware(['auth:api'])->group(function () {
    // profile
    Route::prefix('profile')->name('profile.')->controller(UserProfileController::class)->group(function () {
        Route::get('/', 'show')->name('show');
        Route::post('/update/avatar', 'updateAvatar')->name('update.avatar');
        Route::post('/update', 'update')->name('update');
        Route::post('/update/helper', 'updateHelper')->name('update.helper');
        Route::get('/show/helper', 'showHelper')->name('show.helper');
    });

    // category
    Route::prefix('category')->name('category.')->controller(CategoryController::class)->group(function () {
        Route::get('/paginated/page', 'paginatedIndex')->name('index.paginated');
    });
});


















// Clear all cache and optimize the application
Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');
    return Helper::success(200, 'Cache cleared and application optimized successfully.');
});

// Run migrations
Route::get('/migrate', function () {
    Artisan::call('migrate');
    return Helper::success(200, 'Migrations ran successfully.');
});

// Run fresh migrations (drop all tables and run migrations again)
Route::get('/migrate-fresh', function () {
    Artisan::call('migrate:fresh');
    return Helper::success(200, 'Database refreshed and migrations run successfully.');
});

// Run fresh migrations and seed the database
Route::get('/migrate-fresh-seed', function () {
    Artisan::call('migrate:fresh --seed');
    return Helper::success(200, 'Database refreshed, migrations run, and seeding completed successfully.');
});

// Seed the database
Route::get('/seed', function () {
    Artisan::call('db:seed');
    return Helper::success(200, 'Database seeding completed successfully.');
});

//queue-work
Route::get('/queue-work', function () {
    Artisan::call('queue:work --stop-when-empty');
    return Helper::success(200, 'Queue worker started successfully.');
});


// Run composer update
Route::get('/composer-update', function () {
    $output = shell_exec('composer update 2>&1');
    return Helper::success(200, 'Composer update completed.', $output);
});