<?php

namespace App\Http\Controllers\Web\Public\Anime;

use App\Http\Controllers\Controller;
use App\Models\AnimeWatchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class EpisodeController extends Controller
{
    public function show(string $animeId, string $episodeId, Request $request)
    {
        $anime = Cache::remember('anime-'.$animeId, now()->addMinutes(5), function () use ($animeId) {
            return Http::get(config('app.api_url').'/samehadaku/anime/'.$animeId)->json();
        });

        if ($anime['statusCode'] != 200) {
            abort($anime['statusCode']);
        }

        $episode = Cache::remember('episode-'.$episodeId, now()->addMinutes(5), function () use ($episodeId) {
            return Http::get(config('app.api_url').'/samehadaku/episode/'.$episodeId)->json();
        });

        if ($episode['statusCode'] != 200) {
            abort($episode['statusCode']);
        }

        if ($request->has('server')) {
            $server = $request->get('server');
            $server = Cache::remember('server-'.$server, now()->addMinutes(5), function () use ($server) {
                return Http::get(config('app.api_url').'/samehadaku/server/'.$server)->json();
            });

            if ($server['statusCode'] != 200) {
                abort($server['statusCode']);
            }

            $episode['data']['defaultStreamingUrl'] = $server['data']['url'];
        }

        if (Auth::check()) {
            $user = Auth::user();

            // Use updateOrCreate to check if the record exists and update it, or create a new one
            $animeWatchHistory = AnimeWatchHistory::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'anime_id' => $animeId,
                    'episode_id' => $episodeId,
                ],
                [
                    'data' => [
                        'animeId' => $animeId,
                        'anime' => $anime,
                        'episodeId' => $episodeId,
                        'episode' => $episode,
                    ],
                    'type' => 'anime',
                ]
            );
            $animeWatchHistory->touch();

            // get all anime watch history
            $watchedEpisodes = AnimeWatchHistory::where('user_id', $user->id)->where('anime_id', $animeId)->pluck('episode_id')->toArray();
        } else {
            $watchedEpisodes = [];
        }

        $data = [
            'animeId' => $animeId,
            'anime' => $anime,
            'episodeId' => $episodeId,
            'episode' => $episode,
            'watchedEpisodes' => $watchedEpisodes,
        ];

        return view('public.anime.episode.show', $data);
    }
}
