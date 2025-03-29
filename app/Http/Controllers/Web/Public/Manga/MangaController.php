<?php

namespace App\Http\Controllers\Web\Public\Manga;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class MangaController extends Controller
{
    public function index(): View
    {
        return view('public.manga.index');
    }

    public function show(string $mangaId): View
    {
        $response = Http::get(config('app.consumet_api_url').'/manga/mangadex/info/'.$mangaId)->json();

        $data = [
            'manga' => $response,
        ];

        return view('public.manga.show', $data);
    }

    public function read(string $mangaId, string $chapterId): View
    {
        $manga = Http::get(config('app.consumet_api_url').'/manga/mangadex/info/'.$mangaId)->json();
        $pages = Http::get(config('app.consumet_api_url').'/manga/mangadex/read/'.$chapterId)->json();

        $chapter = collect($manga['chapters'])->firstWhere('id', $chapterId);

        $data = [
            'mangaId' => $mangaId,
            'chapterId' => $chapterId,
            'manga' => $manga,
            'chapter' => $chapter,
            'chapters' => $manga['chapters'],
            'pages' => $pages,
        ];

        return view('public.manga.read', $data);
    }
}
