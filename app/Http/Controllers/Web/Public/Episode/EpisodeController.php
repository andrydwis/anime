<?php

namespace App\Http\Controllers\Web\Public\Episode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class EpisodeController extends Controller
{
    public function show(string $animeId, string $episodeId, Request $request)
    {
        $anime = Cache::remember('anime-'.$animeId, now()->addMinutes(5), function () use ($animeId) {
            return Http::get(config('app.api_url').'/samehadaku/anime/'.$animeId)->json();
        });

        $episode = Cache::remember('episode-'.$episodeId, now()->addMinutes(5), function () use ($episodeId) {
            return Http::get(config('app.api_url').'/samehadaku/episode/'.$episodeId)->json();
        });

        if ($request->has('server')) {
            $server = $request->get('server');
            $server = Cache::remember('server-'.$server, now()->addMinutes(5), function () use ($server) {
                return Http::get(config('app.api_url').'/samehadaku/server/'.$server)->json();
            });

            $episode['data']['defaultStreamingUrl'] = $server['data']['url'];
        }

        $data = [
            'animeId' => $animeId,
            'anime' => $anime,
            'episodeId' => $episodeId,
            'episode' => $episode,
        ];

        return view('public.episode.show', $data);
    }
}
