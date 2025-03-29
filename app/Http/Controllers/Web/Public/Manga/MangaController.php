<?php

namespace App\Http\Controllers\Web\Public\Manga;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class MangaController extends Controller
{
    public function index(): View
    {
        $response = Http::get('https://consumet-nine-hazel.vercel.app/manga/mangadex/read/e7c4d0c9-cec9-4116-aba1-178b2a5d4cc3')->json();

        $data = [
            'pages' => $response,
        ];

        return view('public.manga.index', $data);
    }
}
