<?php

use Illuminate\Support\Facades\Route;

include __DIR__.'/auth.php';

Route::get('/', [App\Http\Controllers\Web\Public\Home\HomeController::class, 'index'])->name('home');

Route::get('/anime', [App\Http\Controllers\Web\Public\Anime\AnimeController::class, 'index'])->name('anime.index');
Route::get('/anime/{id}', [App\Http\Controllers\Web\Public\Anime\AnimeController::class, 'show'])->name('anime.show');
