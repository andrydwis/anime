<?php

namespace App\Services\Scraper;

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
        $html = Http::get(config('app.api_url'))->body();
        $crawler = new Crawler($html);

        $animes = $crawler->filter('.chart')->each(function (Crawler $node) {
            $id = Str::remove('anime.php?', $node->filter('.charttitle.c a')->attr('href'));
            $title = $node->filter('.charttitle.c a')->text();
            $jp_title = $node->filter('.charttitlejp.c')->text();
            $slug = Str::slug($title.'-'.$id);
            $image = config('app.api_url').'/'.$node->filter('img')->attr('src');
            $episodes = $node->filter('.chartep.c2')->text();

            return [
                'id' => $id,
                'title' => $title,
                'jp_title' => $jp_title,
                'slug' => $slug,
                'image' => $image,
                'episodes' => $episodes,
            ];
        });

        // limit get only 16 animes
        $animes = array_slice($animes, 0, 16);

        return [
            'animes' => $animes,
        ];
    }
}
