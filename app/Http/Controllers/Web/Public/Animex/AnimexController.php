<?php

namespace App\Http\Controllers\Web\Public\Animex;

use App\Http\Controllers\Controller;
use App\Models\AnimeWatchHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if (Auth::check()) {
            $user = Auth::user();

            // Use updateOrCreate to check if the record exists and update it, or create a new one
            $animeWatchHistory = AnimeWatchHistory::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'anime_id' => $animeId,
                    'episode_id' => $currentEpisode['episodeId'],
                ],
                [
                    'data' => [
                        'animeId' => $animeId,
                        'anime' => $detail,
                        'episodeId' => $currentEpisode['episodeId'],
                        'episode' => $currentEpisode,
                    ],
                    'type' => 'animex',
                ]
            );
            $animeWatchHistory->touch();

            // get all anime watch history
            $watchedEpisodes = AnimeWatchHistory::where('user_id', $user->id)->where('anime_id', $animeId)->pluck('episode_id')->toArray();
        } else {
            $watchedEpisodes = [];
        }

        $stream = Cache::remember('anime-'.$animeId.'-episode-'.$currentEpisode['episodeNo'], Carbon::now()->addMinutes(5), function () use ($currentEpisode) {
            return Http::get(config('app.beta_api_url').'/aniwatch/episode-srcs', ['id' => $currentEpisode['episodeId']])->json();
        });

        $data = [
            'detail' => $detail,
            'episodes' => $episodes,
            'currentEpisode' => $currentEpisode,
            'watchedEpisodes' => $watchedEpisodes,
            'stream' => $stream,
        ];

        return view('public.animex.show', $data);
    }
}
