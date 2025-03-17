<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Url;
use Livewire\Component;
use Symfony\Component\DomCrawler\Crawler;

class SocialMediaVideoDownloader extends Component
{
    #[Url]
    public string $url = '';

    public string $socialMedia = '';

    public array $data = [];

    public function render()
    {
        return view('livewire.social-media-video-downloader');
    }

    public function download()
    {
        if ($this->url) {
            $this->socialMedia = 'facebook';
            $this->data = $this->handleFacebookVideo();
        } else {
            $this->socialMedia = '';
            $this->data = [];
            $this->addError('url', 'Untuk sekarang hanya support Facebook.');
        }
    }

    public function handleFacebookVideo(): array
    {
        // Set user agent for HTTP request
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36';

        // Fetch the HTML content of the Facebook video page
        $html = Http::withHeaders([
            'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
        ])->get($this->url)->body();

        // Extract the title using a DOM crawler
        $crawler = new Crawler($html);
        $title = $crawler->filter('title')->text();
        $thumbnail = $crawler->filter('meta[property="og:image"]')->attr('content');

        // Extract the SD and HD video URLs using regex
        $sdLink = $this->extractVideoUrl($html, 'browser_native_sd_url');
        $hdLink = $this->extractVideoUrl($html, 'browser_native_hd_url');

        // Get additional metadata (e.g., file size) for the video URLs
        $sdLinkData = $this->getHeaderDatas($sdLink);
        $hdLinkData = $this->getHeaderDatas($hdLink);

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
    }

    /**
     * Extracts a video URL from the HTML content using a specific regex pattern.
     *
     * @param  string  $html  The HTML content of the Facebook video page.
     * @param  string  $key  The key to search for in the HTML (e.g., 'browser_native_sd_url').
     * @return string The extracted video URL, or an empty string if not found.
     */
    private function extractVideoUrl(string $html, string $key): string
    {
        $pattern = '/'.preg_quote($key, '/').'":"([^"]+)"/';
        if (preg_match($pattern, $html, $matches)) {
            return $this->cleanStr($matches[1]).'&dl=1';
        }

        return '';
    }

    /**
     * Cleans a string by decoding JSON-encoded characters.
     *
     * @param  string  $str  The string to clean.
     * @return string The cleaned string.
     */
    private function cleanStr(string $str): string
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
    private function getHeaderDatas(string $url): array
    {
        $headers = get_headers($url, 1);

        return [
            'size' => $headers['Content-Length'] ?? 0,
            'sizeHuman' => $this->formatSizeUnits($headers['Content-Length'] ?? 0),
            'type' => $headers['Content-Type'] ?? '',
        ];
    }

    /**
     * Formats a byte value into a human-readable size string.
     *
     * @param  int  $bytes  The size in bytes.
     * @return string The formatted size string (e.g., "1.23 MB").
     */
    private function formatSizeUnits(int $bytes): string
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
