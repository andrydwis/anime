<?php

namespace App\Http\Controllers\Web\Public\Anime;

use App\Http\Controllers\Controller;
use App\Models\AnimeWatchHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\DomCrawler\Crawler;

class AnimeController extends Controller
{
    public function index(): View
    {
        $animes = Cache::remember('anime', now()->addMinutes(5), function () {
            return Http::get(config('app.api_url').'/samehadaku/anime/')->json();
        });

        $genres = Cache::remember('genres', now()->addMinutes(5), function () {
            return Http::get(config('app.api_url').'/samehadaku/genres/')->json();
        });

        $data = [
            'animes' => $animes,
            'genres' => $genres,
        ];

        return view('public.anime.index', $data);
    }

    public function show(string $animeId): View
    {
        $anime = Cache::remember('anime-'.$animeId, now()->addMinutes(5), function () use ($animeId) {
            return $this->scrapeDetailAnime($animeId);
        });

        $episodes = Cache::remember('episodes-'.$animeId, now()->addMinutes(5), function () use ($animeId) {
            return $this->scrapeEpisodesAnime($animeId);
        });

        if (Auth::check()) {
            $user = Auth::user();

            // get all anime watch history
            $watchedEpisodes = AnimeWatchHistory::where('user_id', $user->id)->where('anime_id', $animeId)->pluck('episode_id')->toArray();
        } else {
            $watchedEpisodes = [];
        }

        $data = [
            'animeId' => $animeId,
            'anime' => $anime,
            'episodes' => $episodes,
            'watchedEpisodes' => $watchedEpisodes,
        ];

        return view('public.anime.show', $data);
    }

    public function scrapeDetailAnime(string $animeId): array
    {
        $html = Http::get(config('app.api_url').'/'.$animeId)->body();
        $crawler = new Crawler($html);

        // Extract Overview
        $details['overview'] = $crawler->filter('.item-title.w-hide .text')->text();

        // Extract Japanese Title
        $details['japanese-title'] = $crawler->filter('.item-title:contains("Japanese") .name')->text();

        // Extract Premiered
        $details['season'] = $crawler->filter('.item-title:contains("Premiered") .name')->text();

        // Extract Duration
        $details['duration'] = $crawler->filter('.item-title:contains("Duration") .name')->text();

        // Extract Status
        $details['status'] = $crawler->filter('.item-title:contains("Status") .name')->text();

        // Extract MAL Score
        $details['mal-score'] = $crawler->filter('.item-title:contains("MAL Score") .name')->text();

        // Extract Genres
        $details['genres'] = [];
        $crawler->filter('.item-list:contains("Genres") a')->each(function (Crawler $node) use (&$details) {
            $details['genres'][] = [
                'id' => Str::remove('/genre/', $node->attr('href')),
                'name' => $node->text(),
            ];
        });

        // Extract Studios
        $details['studios'] = [];
        $crawler->filter('.item-title:contains("Studios") a.name')->each(function (Crawler $node) use (&$details) {
            $details['studios'][] = $node->text();
        });

        // Extract Producers
        $details['producers'] = [];
        $crawler->filter('.item-title:contains("Producers") a.name')->each(function (Crawler $node) use (&$details) {
            $details['producers'][] = $node->text();
        });

        $data = [
            'id' => $animeId,
            'title' => $crawler->filter('.film-name.dynamic-name')->text(),
            'description' => $crawler->filter('.film-description')->text(),
            'image' => $crawler->filter('.film-poster-img')->attr('src'),
            'category' => $crawler->filter('.fdi-item')->text(),
            'duration' => $crawler->filter('.fdi-duration')->text(),
            'episodes' => $crawler->filter('.tick-item.tick-sub')->text(),
            'details' => $details,
        ];

        return $data;
    }

    public function scrapeEpisodesAnime($animeId)
    {
        $numberedId = Str::afterLast($animeId, '-');
        $html = Http::get(config('app.api_url').'/ajax/v2/episode/list/'.$numberedId)->json()['html'];
        $crawler = new Crawler($html);

        $episodes = [];

        // Step 3: Extract episode details
        $crawler->filter('.ssl-item.ep-item')->each(function (Crawler $node) use (&$episodes) {
            $episodeNumber = $node->filter('.ssli-order')->text();
            $episodeTitle = $node->filter('.ep-name')->text();
            $episodeLink = $node->attr('href');
            $episodeId = Str::afterLast($episodeLink, '?ep=');

            // Add to the episodes array
            $episodes[] = [
                'id' => $episodeId,
                'number' => $episodeNumber,
                'title' => $episodeTitle,
                'link' => $episodeLink,
            ];
        });

        return $episodes;
    }
}
