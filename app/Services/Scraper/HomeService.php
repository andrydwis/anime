<?php

namespace App\Services\Scraper;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class HomeService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function scrapeHome(): array
    {
        $html = Http::get(config('app.api_url').'/home')->body();
        $crawler = new Crawler($html);

        $spotlights = $crawler->filter('.deslide-wrap .swiper-slide')->each(function (Crawler $node) {
            return [
                'id' => Str::remove('/', $node->filter('.desi-buttons a.btn.btn-secondary.btn-radius')->attr('href')),
                'title' => $node->filter('.desi-head-title')->text(),
                'description' => $node->filter('.desi-description')->text(),
                'image' => $node->filter('.film-poster-img')->attr('data-src'),
                'category' => $node->filter('.scd-item i.fa-play-circle')->closest('.scd-item')->text(),
                'duration' => $node->filter('.scd-item i.fa-clock')->closest('.scd-item')->text(),
                'episodes' => $node->filter('.tick-item.tick-sub')->text(),
                'release_date' => Carbon::parse($node->filter('.scd-item i.fa-calendar')->closest('.scd-item')->text())->isoFormat('DD MMM YYYY'),
            ];
        });

        $recentAnimesSection = $crawler->filter('.block_area-header:contains("Latest Episode")')->closest('.block_area');
        $recentAnimes = $recentAnimesSection->filter('.flw-item')->each(function (Crawler $node) {
            $id = $node->filter('.film-poster-ahref')->attr('href');
            if (preg_match('/\/watch\/([^?]+)/', $id, $matches)) {
                $id = $matches[1];
            }

            return [
                'id' => $id,
                'title' => $node->filter('.film-name a')->text(),
                'image' => $node->filter('.film-poster-img')->attr('data-src'),
                'category' => $node->filter('.fdi-item')->text(),
                'duration' => $node->filter('.fdi-duration')->text(),
                'episodes' => $node->filter('.tick-item.tick-sub')->text(),
            ];
        });

        $data = [
            'spotlight_animes' => $spotlights,
            'recent_animes' => $recentAnimes,
        ];

        return $data;
    }
}
