<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class TiktokVideoDownloader
{
    public static function parse(string $url): array
    {
        $metadata = Http::get('https://www.tikwm.com/api/', [
            'url' => $url,
        ])->json();

        return $metadata;
    }
}
