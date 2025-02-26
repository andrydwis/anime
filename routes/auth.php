<?php

use Illuminate\Support\Facades\Route;

Route::get('login', [App\Http\Controllers\Web\Auth\LoginController::class, 'index'])->name('login');
