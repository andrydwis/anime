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
        $html = Http::get(config('app.api_url').'/anime.php?'.$animeId)->body();
        $crawler = new Crawler($html);

        $id = $animeId;
        $title = $crawler->filter('.infotitle.c')->text();
        $jp_title = $crawler->filter('.infotitlejp.c')->text();
        $slug = Str::slug($title.'-'.$id);
        $image = $crawler->filter('.infoimg .posterimg')->attr('src');
        $description = $crawler->filter('.infodes.c')->text();
        $genres = $crawler->filter('.boxitem.bc2.c1')->each(function (Crawler $node) {
            return $node->text();
        });
        // Extract the first (and only) .infoyear.c element
        $infoNode = $crawler->filter('.infoyear.c')->first();

        // Extract the .inline.c2 elements
        $infoElements = $infoNode->filter('.inline.c2');

        // Ensure there are enough elements to extract episodes, aired date, and rating
        if ($infoElements->count() >= 3) {
            $episodes = trim($infoElements->eq(0)->text()); // First element: episodes
            $aired = trim($infoElements->eq(1)->text());    // Second element: aired date
            $rating = trim($infoElements->eq(2)->text());   // Third element: rating
        } else {
            // Handle missing or insufficient data
            $episodes = $aired = $rating = null;
        }

        return [
            'id' => $id,
            'title' => $title,
            'jp_title' => $jp_title,
            'slug' => $slug,
            'image' => $image,
            'description' => $description,
            'genres' => $genres,
            'episodes' => $episodes,
            'aired' => $aired,
            'rating' => $rating,
        ];
    }
}
