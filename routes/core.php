<?php

use Illuminate\Support\Facades\Route;

Route::prefix('core')->name('core.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('dashboard', [App\Http\Controllers\Web\Core\Dashboard\DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('users', App\Http\Controllers\Web\Core\User\UserController::class)->only(['index', 'destroy']);
    Route::resource('news', App\Http\Controllers\Web\Core\News\NewsController::class)->scoped(['news' => 'slug'])->except(['show']);
});
