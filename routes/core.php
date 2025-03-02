<?php

use Illuminate\Support\Facades\Route;

Route::prefix('core')->name('core.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Web\Core\Dashboard\DashboardController::class, 'index'])->middleware('auth')->name('dashboard.index');
});
