<?php

use Illuminate\Support\Facades\Route;

include __DIR__.'/auth.php';

Route::get('/', [App\Http\Controllers\Web\Public\Home\HomeController::class, 'index'])->name('home');

Route::get('/anime', [App\Http\Controllers\Web\Public\Anime\AnimeController::class, 'index'])->name('anime.index');
Route::get('/anime/recent', [App\Http\Controllers\Web\Public\Anime\RecentAnimeController::class, 'index'])->name('anime.recent.index');

Route::get('/anime/genre/{genre}', [App\Http\Controllers\Web\Public\Anime\GenreAnimeController::class, 'show'])->name('anime.genre.show');

Route::get('/anime/{anime}', [App\Http\Controllers\Web\Public\Anime\AnimeController::class, 'show'])->name('anime.show');
Route::get('/anime/{anime}/episode/{episode}', [App\Http\Controllers\Web\Public\Episode\EpisodeController::class, 'show'])->name('anime.episode.show');
