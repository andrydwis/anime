<?php

use Illuminate\Support\Facades\Route;

Route::get('register', [App\Http\Controllers\Web\Auth\RegisterController::class, 'index'])->middleware('guest')->name('register');
Route::post('register', [App\Http\Controllers\Web\Auth\RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [App\Http\Controllers\Web\Auth\LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('login', [App\Http\Controllers\Web\Auth\LoginController::class, 'store'])->middleware('guest');

Route::post('logout', [App\Http\Controllers\Web\Auth\LoginController::class, 'destroy'])->middleware('auth')->name('logout');
