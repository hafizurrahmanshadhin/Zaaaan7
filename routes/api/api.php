<?php

use App\Helper\Helper;
use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ChatController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\UserProfileController;
use App\Http\Controllers\API\UserReviewController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;






Route::middleware(['auth:api', 'verified'])->group(function () {
    // profile
    Route::prefix('profile')->name('profile.')->controller(UserProfileController::class)->group(function () {
        Route::middleware(['helper'])->group(function () {
            Route::post('/update/helper', 'updateHelper')->name('update.helper');
            Route::get('/show/helper', 'showHelper')->name('show.helper');
        });
        Route::middleware(['user'])->group(function () {
            Route::get('/', 'show')->name('show');
            Route::post('/update', 'update')->name('update');
            Route::get('/show/helper/{user}', 'showHelperById')->name('show.helper.profile');
            Route::get('/helper/skill/{skill}', 'getHelpersBySkills')->name('show.helper.profile');
            Route::get('/helper/{user}', 'getHelper')->name('show.helper.profile');
            Route::get('/top-exparts', 'topExparts')->name('top.experts');
        });
        Route::post('/update/avatar', 'updateAvatar')->name('update.avatar');
    });
    // address
    Route::prefix('address')->name('address.')->controller(AddressController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::patch('/activate/{address}', 'activate')->name('activate');
        Route::delete('/destroy/{address}', 'destroy')->name('destroy');
    });
    // task
    Route::prefix('/task')->name('task.')->controller(TaskController::class)->group(function () {

        Route::middleware(['user'])->group(function () {
            Route::get('/index', 'userIndex')->name('user.index');
            Route::post('/store', 'store')->name('index');
            Route::get('/experts', 'experts')->name('experts');
            Route::post('/request', 'request')->name('request');
            Route::get('/status/{task}', 'showStatus')->name('status');
        });
        Route::prefix('/helper')->name('helper.')->middleware(['helper'])->group(function () {
            Route::get('/', 'helperIndex')->name('index');
            Route::get('/completed', 'helperCompletedIndex')->name('complete.index');
            Route::get('/reqest', 'helperRequestdIndex')->name('reqest');
            Route::put('/accept/{task}', 'helperRequestAccept')->name('helperRequestAccept');
            Route::get('/{task}', 'show')->name('show');
        });
        Route::get('/{task}', 'show')->name('show');
    });

    //dashboard
    Route::prefix('/dashboard')->name('dashboard.')->controller(DashboardController::class)->group(function () {
        Route::prefix('/helper')->name('helper.')->middleware(['helper'])->group(function () {
            Route::get('/', 'show');
        });
    });

    // category
    Route::prefix('category')->name('category.')->controller(CategoryController::class)->group(function () {
        Route::get('/paginated/page', 'paginatedIndex')->name('index.paginated');
        Route::get('/skills', 'subCategoryIndex')->name('index.skills');
    });
    // review
    Route::prefix('review')->name('review.')->controller(UserReviewController::class)->group(function () {
        Route::get('/client', 'clientIndex')->name('client.index')->middleware('user');
        Route::get('/helper', 'helperIndex')->name('helper.index')->middleware('helper');
        Route::post('/store', 'store')->name('store')->middleware(['user']);
    });
    // message
    Route::controller(ChatController::class)->group(function () {
        Route::get('/messages/{user}',  'getMessages');
        Route::post('/messages/{user}',  'sendMessage');
    });
});


Route::prefix('category')->name('category.')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/sub-category/{category}', 'subCategories')->name('sub.category');
    Route::get('/{category}', 'view')->name('view');
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
