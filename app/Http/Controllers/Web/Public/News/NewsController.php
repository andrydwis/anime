<?php

namespace App\Http\Controllers\Web\Public\News;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $news = Cache::remember('news-'.request()->input('page', 1), now()->addMinutes(5), function () {
            return News::where('is_published', true)->latest()->with(['user', 'media'])->paginate(12)->withQueryString();
        });

        $data = [
            'news' => $news,
        ];

        return view('public.news.index', $data);
    }

    public function show(News $news): View
    {
        if ($news->is_published == false) {
            abort(404);
        }

        $data = [
            'news' => $news,
        ];

        return view('public.news.show', $data);
    }
}
