<?php

namespace App\Http\Controllers\Web\Public\Anime;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Opcodes\LogViewer\Facades\Cache;

class GenreAnimeController extends Controller
{
    public function show(string $genre): View
    {
        $animes = Cache::remember('genre-animes-'.$genre, now()->addMinutes(5), function () use ($genre) {
            return Http::get(config('app.api_url').'/samehadaku/genres/'.$genre)->json();
        });

        $data = [
            'genreId' => $genre,
            'animes' => $animes,
        ];

        return view('public.anime.genre.show', $data);
    }
}
