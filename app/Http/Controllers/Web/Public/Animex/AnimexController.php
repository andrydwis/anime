<?php

namespace App\Http\Controllers\Web\Public\Animex;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class AnimexController extends Controller
{
    public function index(): View
    {
        // $home = Http::get(config('app.beta_api_url').'/aniwatch')->json();
        $home = Cache::remember('home-animex', Carbon::now()->addMinutes(5), function () {
            return Http::get(config('app.beta_api_url').'/aniwatch')->json();
        });

        $data = [
            'home' => $home,
        ];

        return view('public.animex.index', $data);
    }

    public function show(string $animeId, Request $request): View
    {
        $detail = Cache::remember('anime-'.$animeId, Carbon::now()->addMinutes(5), function () use ($animeId) {
            return Http::get(config('app.beta_api_url').'/aniwatch/anime/'.$animeId)->json();
        });
        $episodes = Cache::remember('anime-'.$animeId.'-episodes', Carbon::now()->addMinutes(5), function () use ($animeId) {
            return Http::get(config('app.beta_api_url').'/aniwatch/episodes/'.$animeId)->json();
        });

        if ($request->has('episode')) {
            $currentEpisode = collect($episodes['episodes'])->where('episodeId', $request->get('episode'))->first();
        } else {
            $currentEpisode = collect($episodes['episodes'])->last();
        }

        $stream = Cache::remember('anime-'.$animeId.'-episode-'.$currentEpisode['episodeNo'], Carbon::now()->addMinutes(5), function () use ($currentEpisode) {
            return Http::get(config('app.beta_api_url').'/aniwatch/episode-srcs', ['id' => $currentEpisode['episodeId']])->json();
        });

        $data = [
            'detail' => $detail,
            'episodes' => $episodes,
            'currentEpisode' => $currentEpisode,
            'stream' => $stream,
        ];

        return view('public.animex.show', $data);
    }
}
