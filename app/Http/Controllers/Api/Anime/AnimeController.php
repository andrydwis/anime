<?php

namespace App\Http\Controllers\Api\Anime;

use App\Http\Controllers\Controller;
use App\Services\Scraper\AnimeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class AnimeController extends Controller
{
    public function show(string $animeId): JsonResponse
    {
        $data = Cache::remember('anime-'.$animeId, now()->addDay(), function () use ($animeId) {
            return AnimeService::scrapeDetailAnime($animeId);
        });

        return response()->json($data);
    }
}
