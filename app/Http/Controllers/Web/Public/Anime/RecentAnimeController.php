<?php

namespace App\Http\Controllers\Web\Public\Anime;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class RecentAnimeController extends Controller
{
    public function index(Request $request): View
    {
        $animes = Cache::remember('recent-animes-'.$request->input('page', 1), now()->addMinutes(5), function () use ($request) {
            return Http::get(config('app.api_url').'/samehadaku/recent', ['page' => $request->input('page', 1)])->json();
        });

        $data = [
            'animes' => $animes,
        ];

        return view('public.anime.recent.index', $data);
    }
}
