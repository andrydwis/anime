<?php

namespace App\Services\Scraper;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class AnimeService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function scrapeDetailAnime(string $animeId): array
    {
        $html = Http::get(config('app.api_url').'/'.$animeId)->body();
        $crawler = new Crawler($html);

        $malId = $crawler->filter('#syncData')->text();
        $malId = json_decode($malId, true)['mal_id'];

        // Extract Overview
        $details['overview'] = $crawler->filter('.item-title.w-hide .text')->text();

        // Extract Japanese Title
        $details['japanese_title'] = $crawler->filter('.item-title:contains("Japanese") .name')->text();

        // Extract Premiered
        $details['season'] = $crawler->filter('.item-title:contains("Premiered") .name')->text();

        // Extract Duration
        $details['duration'] = $crawler->filter('.item-title:contains("Duration") .name')->text();

        // Extract Status
        $details['status'] = $crawler->filter('.item-title:contains("Status") .name')->text();

        // Extract MAL Score
        $details['mal_score'] = $crawler->filter('.item-title:contains("MAL Score") .name')->text();

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

        // Extract Seasons
        $seasons = [];
        $crawler->filter('a.os-item')->each(function (Crawler $node) use (&$seasons) {
            // Extract the title
            $title = $node->filter('div.title')->text();

            // Extract the URL
            $url = $node->attr('href');

            $id = Str::remove('/', $url);

            // if has .active class, then it is the current season
            $isCurrent = $node->filter('.active')->count() > 0;

            // Add the data to the seasons array
            $seasons[] = [
                'id' => $id,
                'title' => $title,
                'url' => $url,
                'is_current' => $isCurrent,
            ];
        });

        $data = [
            'id' => $animeId,
            'mal_id' => $malId,
            'title' => $crawler->filter('.film-name.dynamic-name')->text(),
            'description' => $crawler->filter('.film-description')->text(),
            'image' => $crawler->filter('.film-poster-img')->attr('src'),
            'category' => $crawler->filter('.fdi-item')->text(),
            'duration' => $crawler->filter('.fdi-duration')->text(),
            'episodes' => $crawler->filter('.tick-item.tick-sub')->text(),
            'details' => $details,
            'seasons' => $seasons,
        ];

        return $data;
    }
}
