<?php

namespace App\Http\Controllers\Web\Public\Home;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $home = Cache::remember('home', now()->addMinutes(5), function () {
            return Http::get(config('app.api_url').'/samehadaku/home')->json();
        });
        $news = Cache::remember('news', now()->addMinutes(5), function () {
            return News::where('is_published', true)->latest()->with(['media'])->limit(4)->get();
        });

        $data = [
            'home' => $home,
            'news' => $news
        ];

        return view('public.home.index', $data);
    }
}
