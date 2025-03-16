<?php

namespace App\Http\Controllers\Web\Public\Animex;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\DomCrawler\Crawler;

class AnimexController extends Controller
{
    public function index(): View
    {
        $data = [
            'animes' => Cache::remember('home-animex', Carbon::now()->addHour(), function () {
                return $this->getRecentAnimes();
            }),
        ];

        return view('public.animex.index', $data);
    }

    public function show(string $animeId, Request $request): View
    {
        $data = [
            'detail' => Cache::remember('animex-'.$animeId, Carbon::now()->addHour(), function () use ($animeId) {
                return $this->getDetailAnime($animeId);
            }),
        ];

        if ($request->has('episode')) {
            $data['episode'] = $this->getDetailEpisode($request->get('episode'));
        } else {
            // latest episode, last array item of $data['detail']['episodes']
            $data['episode'] = $this->getDetailEpisode($data['detail']['episodes'][count($data['detail']['episodes']) - 1]['id']);
        }

        return view('public.animex.show', $data);
    }

    /**
     * Get a list of recent anime series from 9anime
     *
     * @return array An array of objects containing the anime series ID, name, image URL, type, and status
     */
    public function getRecentAnimes()
    {
        // Fetch the HTML content from the 9anime website
        $html = Http::get('https://9anime.org.cv/series/?status=&type=&order=update')->body();

        // Initialize the DomCrawler with the HTML content
        $crawler = new Crawler($html);

        // Extract data for each anime series
        $animeList = $crawler->filter('.bs')->each(function (Crawler $animeNode) {
            // Extract the full link
            $fullLink = $animeNode->filter('a')->attr('href');

            // Extract the slug by removing the base URL and '/series/' prefix
            $slug = preg_replace('#^https?://[^/]+/series/#', '', $fullLink);

            return [
                'id' => rtrim($slug, '/'), // Remove trailing slash if present
                'name' => $animeNode->filter('.tt h2')->text(),
                'image' => $animeNode->filter('.ts-post-image')->attr('src'),
                'type' => $animeNode->filter('.typez')->text(),
                'status' => $animeNode->filter('.epx')->text(),
            ];
        });

        // Return the list of anime series
        return $animeList;
    }

    /**
     * Get the details of a specific anime series from 9anime
     *
     * @param  string  $animeId  The ID of the anime series
     * @return array An array of objects containing the anime series details
     */
    public function getDetailAnime(string $animeId)
    {
        $html = Http::get('https://9anime.org.cv/series/'.$animeId)->body();

        // Initialize the DomCrawler with the HTML content
        $crawler = new Crawler($html);

        // Extract the name
        $name = $crawler->filter('h1.entry-title')->text();

        // Extract the image URL
        $image = $crawler->filter('.thumb img')->attr('src');

        // Extract the numeric rating using a regular expression
        $ratingText = $crawler->filter('.rating strong')->text();
        preg_match('/\d+(\.\d+)?/', $ratingText, $matches);
        $rating = $matches[0] ?? null; // Extract the first match (numeric value)

        // Extract the description
        $description = trim($crawler->filter('.desc')->text());

        // Extract episode links
        $episodes = $crawler->filter('.eplister .ep-item')->each(function (Crawler $episodeNode) {
            $fullLink = $episodeNode->attr('href');
            $slug = preg_replace('#^https?://[^/]+/#', '', $fullLink);

            return [
                'number' => $episodeNode->attr('data-number'),
                'id' => rtrim($slug, '/'),
            ];
        });

        // Extract metadata (status, studio, released date, etc.)
        $metadata = [];
        $crawler->filter('.info-content .spe span')->each(function (Crawler $node) use (&$metadata) {
            $keyValue = explode(':', $node->text(), 2);
            if (count($keyValue) === 2) {
                $key = Str::slug(trim($keyValue[0]));
                $value = trim($keyValue[1]);
                $metadata[$key] = $value;
            }
        });

        // Extract genres
        $genres = $crawler->filter('.genxed a')->each(function (Crawler $node) {
            return $node->text();
        });

        return [
            'id' => $animeId,
            'name' => $name,
            'image' => $image,
            'rating' => $rating,
            'description' => $description,
            'episodes' => $episodes,
            'metadata' => $metadata,
            'genres' => $genres,
        ];
    }

    public function getDetailEpisode(string $episodeId)
    {
        $html = Http::get('https://9anime.org.cv/'.$episodeId)->body();

        // Initialize the DomCrawler with the HTML content
        $crawler = new Crawler($html);

        // Extract iframe link
        $iframe = $crawler->filter('iframe')->attr('src');

        return [
            'iframe' => $iframe,
        ];
    }
}
