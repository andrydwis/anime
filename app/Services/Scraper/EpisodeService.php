<?php

namespace App\Services\Scraper;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class EpisodeService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function scrapeEpisodesAnime($animeId)
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
