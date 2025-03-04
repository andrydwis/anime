<?php

namespace App\Http\Controllers\Web\Core\News;

use App\Http\Controllers\Controller;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

class NewsController extends Controller
{
    public function index(): View
    {
        $data = [
            'news' => News::latest()->with(['user', 'media'])->paginate(10)->withQueryString(),
        ];

        return view('core.news.index', $data);
    }

    public function create(): View
    {
        return view('core.news.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $htmlSanitizer = new HtmlSanitizer(
            (new HtmlSanitizerConfig)->allowSafeElements()
        );
        $content = $htmlSanitizer->sanitize($request->input('content'));

        $news = new News;
        $news->title = $request->input('title');
        $news->slug = Str::slug($request->input('title')).'-'.Carbon::now()->timestamp;
        $news->content = $content;
        $news->user_id = Auth::id();
        $news->save();

        if ($request->hasFile('image')) {
            $news->addMediaFromRequest('image')->toMediaCollection('news');
        }

        Cache::clear('news');

        session()->flash('success', 'Berita berhasil ditambahkan.');

        return redirect()->route('core.news.index');
    }

    public function edit(News $news): View
    {
        $data = [
            'news' => $news,
        ];

        return view('core.news.edit', $data);
    }

    public function update(Request $request, News $news): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $htmlSanitizer = new HtmlSanitizer(
            (new HtmlSanitizerConfig)->allowSafeElements()
        );
        $content = $htmlSanitizer->sanitize($request->input('content'));

        $news->title = $request->input('title');
        $news->content = $content;
        $news->save();

        if ($request->hasFile('image')) {
            $news->clearMediaCollection('news');
            $news->addMediaFromRequest('image')->toMediaCollection('news');
        }

        Cache::clear('news');

        session()->flash('success', 'Berita berhasil diubah.');

        return redirect()->route('core.news.index');
    }

    public function destroy(News $news): RedirectResponse
    {
        $news->delete();

        Cache::clear('news');

        session()->flash('success', 'Berita berhasil dihapus.');

        return redirect()->route('core.news.index');
    }
}
