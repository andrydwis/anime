<?php

namespace App\Http\Controllers\Web\Public\Anime;

use App\Http\Controllers\Controller;
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

        $data = [
            'animeId' => $animeId,
            'anime' => $anime,
        ];

        return view('public.anime.show', $data);
    }
}
