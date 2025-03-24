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

    public static function scrapeEpisodesAnime(string $animeId)
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

    public static function scrapeEpisodeSources(string $episodeId)
    {
        // https:// hianime.to/ajax/v2/episode/sources?id=1139831
        $json = Http::get(config('app.api_url').'/ajax/v2/episode/servers?episodeId='.$episodeId)->json();
        $crawler = new Crawler($json['html']);

        $episode = $crawler->filter('.server-notice strong')->text();
        $episode = trim(Str::replace('You are watching', '', $episode));

        $subServers = [];
        $dubServers = [];

        $crawler->filter('.servers-sub .item.server-item')->each(function (Crawler $node) use (&$subServers) {
            $dataId = $node->attr('data-id');
            $json = Http::get(config('app.api_url').'/ajax/v2/episode/sources?id='.$dataId)->json();
            $subServers[] = [
                'name' => $node->filter('.btn')->text(),
                'data_id' => $dataId,
                'data_server_id' => $node->attr('data-server-id'),
                'url' => $json['link'],
            ];
        });
        $crawler->filter('.servers-dub .item.server-item')->each(function (Crawler $node) use (&$dubServers) {
            $dataId = $node->attr('data-id');
            $json = Http::get(config('app.api_url').'/ajax/v2/episode/sources?id='.$dataId)->json();
            $dubServers[] = [
                'name' => $node->filter('.btn')->text(),
                'data_id' => $dataId,
                'data_server_id' => $node->attr('data-server-id'),
                'url' => $json['link'],
            ];
        });

        $sources = [
            'episode' => $episode,
            'sub' => $subServers,
            'dub' => $dubServers,
            'default' => $subServers[0] ?? $dubServers[0] ?? null,
        ];

        return $sources;
    }
}
