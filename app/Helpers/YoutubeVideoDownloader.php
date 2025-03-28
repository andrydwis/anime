<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class YoutubeVideoDownloader
{
    /**
     * Downloads metadata and video URLs for a given Facebook video.
     *
     * @param  string  $url  The URL of the Facebook video.
     * @return array An associative array containing the title, thumbnail, and video links.
     *
     * @throws \Exception If the download process fails.
     */
    public static function parse(string $url): array
    {
        try {
            $apiUrl = 'https://api.weaboo.my.id';

            $response = Http::withHeaders(['Accept' => 'application/json'])->get($apiUrl.'/extract-metadata', ['platform' => 'youtube', 'video_url' => $url]);
            $data = $response->json();

            return $data;
        } catch (\Exception $e) {
            throw new \Exception('Failed to download video: '.$e->getMessage());
        }
    }
}
