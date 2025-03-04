<?php

namespace App\Http\Controllers\Web\Public\News;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $data = [
            'news' => News::latest()->with(['user', 'media'])->paginate(10)->withQueryString(),
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
