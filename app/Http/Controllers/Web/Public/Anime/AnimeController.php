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

    public function show($id): View
    {
        $anime = Cache::remember('anime-'.$id, now()->addMinutes(5), function () use ($id) {
            return Http::get(config('app.api_url').'/samehadaku/anime/'.$id)->json();
        });

        $data = [
            'anime' => $anime,
        ];

        return view('public.anime.show', $data);
    }
}
