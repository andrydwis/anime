<?php

namespace App\Http\Controllers\Api\Anime;

use App\Http\Controllers\Controller;
use App\Services\Scraper\EpisodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class EpisodeController extends Controller
{
    public function index(string $animeId): JsonResponse
    {
        $episodes = Cache::remember('episodes-'.$animeId, now()->addHour(), function () use ($animeId) {
            return EpisodeService::scrapeEpisodesAnime($animeId);
        });

        return response()->json($episodes);
    }
}
