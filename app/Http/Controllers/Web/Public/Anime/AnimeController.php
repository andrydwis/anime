<?php

namespace App\Http\Controllers\Web\Public\Anime;

use App\Http\Controllers\Controller;
use App\Models\AnimeWatchHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class AnimeController extends Controller
{
    public function index(): View
    {
        $animes = Cache::remember('anime', now()->addMinutes(5), function () {
            return Http::get(config('app.api_url').'/samehadaku/anime/')->json();
        });

        $genres = Cache::remember('genres', now()->addMinutes(5), function () {
            return Http::get(config('app.api_url').'/samehadaku/genres/')->json();
        });

        $data = [
            'animes' => $animes,
            'genres' => $genres,
        ];

        return view('public.anime.index', $data);
    }

    public function show(string $animeId): View
    {
        $anime = Cache::remember('anime-'.$animeId, now()->addMinutes(5), function () use ($animeId) {
            return Http::get(config('app.api_url').'/samehadaku/anime/'.$animeId)->json();
        });

        if (Auth::check()) {
            $user = Auth::user();

            // get all anime watch history
            $watchedEpisodes = AnimeWatchHistory::where('user_id', $user->id)->where('anime_id', $animeId)->pluck('episode_id')->toArray();
        } else {
            $watchedEpisodes = [];
        }

        $data = [
            'animeId' => $animeId,
            'anime' => $anime,
            'watchedEpisodes' => $watchedEpisodes,
        ];

        return view('public.anime.show', $data);
    }
}
