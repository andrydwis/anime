<?php

namespace App\Http\Controllers\Web\Public\Home;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\DomCrawler\Crawler;

class HomeController extends Controller
{
    public function index(): View
    {
        $home = Cache::remember('home', now()->addMinutes(5), function () {
            return $this->scrape();
        });
        $news = Cache::remember('news', now()->addMinutes(5), function () {
            return News::where('is_published', true)->latest()->with(['media'])->limit(4)->get();
        });
        $events = Cache::remember('events', now()->addMinutes(5), function () {
            return Event::where('is_published', true)->orderBy('start_date', 'asc')->orderBy('created_at', 'desc')->with(['media'])->limit(4)->get();
        });

        $data = [
            'home' => $home,
            'news' => $news,
            'events' => $events,
        ];

        return view('public.home.index', $data);
    }

    public function scrape(): array
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
                'release-date' => Carbon::parse($node->filter('.scd-item i.fa-calendar')->closest('.scd-item')->text())->isoFormat('DD MMM YYYY'),
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
            'spotlight-animes' => $spotlights,
            'recent-animes' => $recentAnimes,
        ];

        return $data;
    }
}
