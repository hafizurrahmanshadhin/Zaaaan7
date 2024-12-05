<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProfileController;

Route::get('/dashboard', function () {
    return 'welocme';
})->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});