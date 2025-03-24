<?php

use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/home', [\App\Http\Controllers\Api\Home\HomeController::class, 'index']);
ROute::get('/anime/{animeId}', [\App\Http\Controllers\Api\Anime\AnimeController::class, 'show']);
Route::get('/anime/{animeId}/episodes', [\App\Http\Controllers\Api\Anime\EpisodeController::class, 'index']);
Route::get('/anime/{animeId}/episodes/{episodeId}', [\App\Http\Controllers\Api\Anime\EpisodeController::class, 'show']);
