<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class InstagramVideoDownloader
{
    public static function parse(string $url): array
    {
        $response = Http::get('https://instagram-downloader-download-instagram-videos-stories.p.rapidapi.com/index', [
            'url' => $url,
        ])->json();

        dd($response);

        return $response;
    }
}
