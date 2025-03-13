<?php

namespace App\Http\Controllers\Web\Core\News;

use App\Http\Controllers\Controller;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\DomCrawler\Crawler;

class NewsController extends Controller
{
    public function index(): View
    {
        $data = [
            'news' => News::latest()->with(['user', 'media'])->paginate(10)->withQueryString(),
        ];

        return view('core.news.index', $data);
    }

    public function create(Request $request): View
    {
        if ($request->input('url')) {
            $newsData = $this->scrapeNews($request->input('url'));
            $translate = $this->translate($newsData['title'], $newsData['content']);

            $newsData['title'] = $translate['title'];
            $newsData['content'] = $translate['content'];
        } else {
            $newsData = [];
        }

        $data = [
            'newsData' => $newsData,
        ];

        return view('core.news.create', $data);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'image_url' => ['nullable', 'string', 'url'],
        ]);

        $news = new News;
        $news->title = $request->input('title');
        $news->slug = Str::slug($request->input('title')).'-'.Carbon::now()->format('dmY');
        $news->content = Str::sanitizeHtml($request->input('content'));
        $news->user_id = Auth::id();
        $news->save();

        if ($request->hasFile('image')) {
            $news->addMediaFromRequest('image')->toMediaCollection('news');
        } elseif ($request->has('image_url')) {
            if (! empty($request->input('image_url'))) {
                $news->addMediaFromUrl($request->input('image_url'))->toMediaCollection('news');
            }
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
            'image_url' => ['nullable', 'string', 'url'],
        ]);

        $news->title = $request->input('title');
        $news->content = Str::sanitizeHtml($request->input('content'));
        $news->save();

        if ($request->hasFile('image')) {
            $news->clearMediaCollection('news');
            $news->addMediaFromRequest('image')->toMediaCollection('news');
        } elseif ($request->has('image_url')) {
            if (! empty($request->input('image_url'))) {
                $news->clearMediaCollection('news');
                $news->addMediaFromUrl($request->input('image_url'))->toMediaCollection('news');
            }
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

    public function translate(string $title, string $content): array
    {

        $prompt = 'Translate the following text into BAHASA INDONESIA. The JSON object must use the schema {"title": "judul terjemahan", "content": "konten terjemahan"}';

        $messages = [
            ['role' => 'user', 'content' => $prompt],
            ['role' => 'user', 'content' => "Judul: $title\nKonten: $content"],
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.config('openai.api_key'), // Use your API key from .env
            'Content-Type' => 'application/json',
        ])
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'messages' => $messages,
                'model' => 'mixtral-8x7b-32768',
                'response_format' => [
                    'type' => 'json_object',
                ],
                'temperature' => 0.7,
            ]);

        // Check the response
        if ($response->successful()) {
            $data = $response->json(); // Get the JSON response

            // Process the data as needed
            return json_decode($data['choices'][0]['message']['content'], true);
        } else {
            // Handle errors
            $error = $response->body(); // Get the error response body
            $statusCode = $response->status(); // Get the HTTP status code
            dd("Error: {$error}, Status Code: {$statusCode}");
        }

        return [
            'title' => $title,
            'content' => $content,
        ];
    }

    public function scrapeNews(string $url): array
    {
        $response = Http::get($url);
        $html = $response->body();

        $crawler = new Crawler($html);

        // Extract title
        $title = $crawler->filter('h1.title a')->count() > 0
        ? trim($crawler->filter('h1.title a')->text())
        : null;

        // Extract image URL
        $image = $crawler->filter('.content img.userimg')->count() > 0
            ? $crawler->filter('.content img.userimg')->attr('src')
            : null;

        // Extract content
        $content = $crawler->filter('.content')->count() > 0
            ? trim($crawler->filter('.content')->html())
            : null;

        // Extract tags
        $tags = $crawler->filter('.tags a')->each(function (Crawler $tagNode) {
            return [
                'name' => trim($tagNode->text()),
                'url' => $tagNode->attr('href'),
            ];
        });

        return [
            'title' => $title,
            'image' => $image,
            'content' => $content,
            'tags' => $tags,
        ];
    }
}
