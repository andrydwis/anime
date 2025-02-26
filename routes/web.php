<?php

use Illuminate\Support\Facades\Route;

include __DIR__.'/auth.php';

Route::get('/', [App\Http\Controllers\Web\Home\HomeController::class, 'index'])->name('home');
