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
        return view('public.anime.index');
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
