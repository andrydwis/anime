<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class FacebookVideoDownloader
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
            // Fetch the HTML content of the Facebook video page
            $response = Http::withHeaders([
                'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            ])->get($url);

            if ($response->failed()) {
                throw new \Exception('Failed to fetch the video page.');
            }

            $html = $response->body();

            // Extract the title and thumbnail using a DOM crawler
            $crawler = new Crawler($html);
            $title = $crawler->filter('title')->count() ? $crawler->filter('title')->text() : 'Untitled Video';
            $thumbnail = $crawler->filter('meta[property="og:image"]')->count()
                ? $crawler->filter('meta[property="og:image"]')->attr('content')
                : '';

            // Extract the SD and HD video URLs using regex
            $sdLink = self::extractVideoUrl($html, 'browser_native_sd_url');
            $hdLink = self::extractVideoUrl($html, 'browser_native_hd_url');

            // Get additional metadata (e.g., file size) for the video URLs
            $sdLinkData = self::getHeaderDatas($sdLink);
            $hdLinkData = self::getHeaderDatas($hdLink);

            // Return the structured data
            return [
                'title' => $title,
                'thumbnail' => $thumbnail,
                'videos' => [
                    'sd' => [
                        'url' => $sdLink,
                        'metadata' => $sdLinkData,
                    ],
                    'hd' => [
                        'url' => $hdLink,
                        'metadata' => $hdLinkData,
                    ],
                ],
            ];
        } catch (\Exception $e) {
            throw new \Exception('Error downloading video: '.$e->getMessage());
        }
    }

    /**
     * Extracts a video URL from the HTML content using a specific regex pattern.
     *
     * @param  string  $html  The HTML content of the Facebook video page.
     * @param  string  $key  The key to search for in the HTML (e.g., 'browser_native_sd_url').
     * @return string The extracted video URL, or an empty string if not found.
     */
    private static function extractVideoUrl(string $html, string $key): string
    {
        $pattern = '/'.preg_quote($key, '/').'":"([^"]+)"/';
        if (preg_match($pattern, $html, $matches)) {
            return self::cleanStr($matches[1]).'&dl=1';
        }

        return '';
    }

    /**
     * Cleans a string by decoding JSON-encoded characters.
     *
     * @param  string  $str  The string to clean.
     * @return string The cleaned string.
     */
    private static function cleanStr(string $str): string
    {
        $tmpStr = "{\"text\": \"{$str}\"}";

        return json_decode($tmpStr)->text;
    }

    /**
     * Fetches header data (e.g., file size, content type) for a given URL.
     *
     * @param  string  $url  The URL to fetch header data for.
     * @return array An array containing the file size and content type.
     */
    private static function getHeaderDatas(string $url): array
    {
        if (empty($url)) {
            return [
                'size' => 0,
                'sizeHuman' => '0 bytes',
                'type' => '',
            ];
        }

        $context = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
        $headers = get_headers($url, 1, $context);

        return [
            'size' => $headers['Content-Length'] ?? 0,
            'sizeHuman' => self::formatSizeUnits($headers['Content-Length'] ?? 0),
            'type' => $headers['Content-Type'] ?? '',
        ];
    }

    /**
     * Formats a byte value into a human-readable size string.
     *
     * @param  int  $bytes  The size in bytes.
     * @return string The formatted size string (e.g., "1.23 MB").
     */
    private static function formatSizeUnits(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2).' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2).' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2).' KB';
        } elseif ($bytes > 1) {
            return $bytes.' bytes';
        } elseif ($bytes == 1) {
            return $bytes.' byte';
        } else {
            return '0 bytes';
        }
    }
}
