<?php

namespace App\Http\Controllers\Web\Public\Anime;

use App\Http\Controllers\Controller;
use App\Models\AnimeWatchHistory;
use App\Services\Scraper\AnimeService;
use App\Services\Scraper\EpisodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class EpisodeController extends Controller
{
    public function show(string $animeId, string $episodeId, Request $request)
    {
        $anime = Cache::remember('anime-'.$animeId, now()->addDay(), function () use ($animeId) {
            return AnimeService::scrapeDetailAnime($animeId);
        });

        $episodes = Cache::remember('episodes-'.$animeId, now()->addHour(), function () use ($animeId) {
            return EpisodeService::scrapeEpisodesAnime($animeId);
        });

        $episode = Cache::remember('episode-'.$episodeId, now()->addHour(), function () use ($episodeId) {
            return EpisodeService::scrapeEpisodeSources($episodeId);
        });

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
            'episodes' => $episodes,
            'watchedEpisodes' => $watchedEpisodes,
        ];

        return view('public.anime.episode.show', $data);
    }
}
