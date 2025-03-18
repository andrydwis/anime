<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class SnapSaveDecoder
{
    public static function parse(string $url): array
    {
        $response = Http::withHeaders(
            [
                'accept' => '*/*',
                'content-type' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'origin' => 'https://snapsave.app',
                'referer' => 'https://snapsave.app/en',
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36',
            ]
        )->asForm()->post('https://snapsave.app/action.php?lang=en', [
            'url' => $url,
        ]);

        // Check if the response was successful
        if ($response->successful()) {
            // Parse the response body (assuming JSON)
            $html = $response->body();

            // Return the parsed data as an array
            $decoder = new self;
            $decodedHtml = $decoder->decryptSnapSave($html);

            $crawler = new Crawler($decodedHtml);
            $html = $crawler->filter('a')->attr('href');

            // Initialize data and media arrays
            $data = [];
            $media = [];

            // Check if the table or article.media > figure exists
            if ($crawler->filter('table.table')->count() || $crawler->filter('article.media > figure')->count()) {
                // Extract description and preview
                $description = trim($crawler->filter('span.video-des')->text());
                $preview = $crawler->filter('article.media > figure img')->attr('src');
                $data['description'] = $description;
                $data['preview'] = $preview;

                // If table exists, extract media data from table rows
                if ($crawler->filter('table.table')->count()) {
                    $crawler->filter('tbody > tr')->each(function (Crawler $tr) use (&$media) {
                        $resolution = trim($tr->filter('td')->eq(0)->text());
                        $urlElement = $tr->filter('td')->eq(2)->filter('a, button');
                        $url = $urlElement->attr('href') ?? $urlElement->attr('onclick');

                        $shouldRender = preg_match('/get_progressApi/', $url ?? '');
                        if ($shouldRender) {
                            preg_match("/get_progressApi\('(.*?)'\)/", $url, $matches);
                            $url = 'https://snapsave.app'.($matches[1] ?? $url);
                        }

                        $media[] = [
                            'resolution' => $resolution,
                            'shouldRender' => $shouldRender ? true : null,
                            'url' => $url,
                            'type' => $resolution ? 'video' : 'image',
                        ];
                    });
                }
                // If div.card exists, extract media data from card elements
                elseif ($crawler->filter('div.card')->count()) {
                    $crawler->filter('div.card')->each(function (Crawler $card) use (&$media) {
                        $cardBody = $card->filter('div.card-body');
                        $aText = trim($cardBody->filter('a')->text());
                        $url = $cardBody->filter('a')->attr('href');
                        $type = $aText === 'Download Photo' ? 'image' : 'video';

                        $media[] = [
                            'url' => $url,
                            'type' => $type,
                        ];
                    });
                }
                // Fallback to extracting URL from anchor or button
                else {
                    $url = $crawler->filter('a')->attr('href') ?? $crawler->filter('button')->attr('onclick');
                    $aText = trim($crawler->filter('a')->text());
                    $type = $aText === 'Download Photo' ? 'image' : 'video';

                    $media[] = [
                        'url' => $url,
                        'type' => $type,
                    ];
                }
            }
            // If div.download-items exists, extract media data from download items
            elseif ($crawler->filter('div.download-items')->count()) {
                $crawler->filter('div.download-items')->each(function (Crawler $item) use (&$media, $decoder) {
                    $thumbnail = $item->filter('div.download-items__thumb > img')->attr('src');
                    $btn = $item->filter('div.download-items__btn');
                    $url = $btn->filter('a')->attr('href');
                    $spanText = trim($btn->filter('span')->text());
                    $type = $spanText === 'Download Photo' ? 'image' : 'video';

                    $media[] = [
                        'url' => $url,
                        'thumbnail' => $type === 'video' ? $decoder->fixThumbnail($thumbnail) : null,
                        'type' => $type,
                    ];
                });
            }

            // Return blank data if no media was found
            if (empty($media)) {
                return ['success' => false, 'message' => 'Blank data'];
            }

            // Return the final data
            return ['success' => true, 'data' => array_merge($data, ['media' => $media])];

        } else {
            // Handle unsuccessful response
            throw new \Exception('Failed to fetch data: '.$response->status());
        }
    }

    // Helper function to fix thumbnail URLs (to be implemented)
    public function fixThumbnail(string $url): string
    {
        $toReplace = 'https://snapinsta.app/photo.php?photo=';
        if (strpos($url, $toReplace) !== false) {
            // Replace the target string and decode the remaining part of the URL
            return urldecode(str_replace($toReplace, '', $url));
        }

        // Return the original URL if no replacement is needed
        return $url;
    }

    public function decodeSnapApp($args)
    {
        [$h, $u, $n, $t, $e, $r] = $args;

        function decode($d, $e, $f)
        {
            $g = str_split('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+/');
            $h = array_slice($g, 0, $e);
            $i = array_slice($g, 0, $f);

            $j = 0;
            $chars = str_split(strrev($d));
            foreach ($chars as $c => $b) {
                if (($index = array_search($b, $h)) !== false) {
                    $j += $index * pow($e, $c);
                }
            }

            $k = '';
            while ($j > 0) {
                $k = $i[$j % $f].$k;
                $j = ($j - ($j % $f)) / $f;
            }

            return $k ?: '0';
        }

        $r = '';
        for ($i = 0, $len = strlen($h); $i < $len; $i++) {
            $s = '';
            while ($h[$i] !== $n[(int) $e]) {
                $s .= $h[$i];
                $i++;
            }
            for ($j = 0; $j < strlen($n); $j++) {
                $s = preg_replace('/'.preg_quote($n[$j], '/').'/', $j, $s);
            }
            $r .= chr(decode($s, $e, 10) - $t);
        }

        $fixEncoding = function ($str) {
            $bytes = array_map('ord', str_split($str));

            return mb_convert_encoding(pack('C*', ...$bytes), 'UTF-8', 'UTF-8');
        };

        return $fixEncoding($r);
    }

    public function getEncodedSnapApp($data)
    {
        preg_match('/decodeURIComponent\(escape\(r\)\)}\((.*?)\)\)/', $data, $matches);
        $encodedArgs = explode(',', $matches[1]);

        return array_map(function ($v) {
            return trim(str_replace('"', '', $v));
        }, $encodedArgs);
    }

    public function getDecodedSnapSave($data)
    {
        preg_match('/getElementById\("download-section"\).innerHTML = "(.*?)"; document.getElementById\("inputData"\).remove\(\);/', $data, $matches);

        return str_replace(['\\', '\\\\'], '', $matches[1]);
    }

    public function decryptSnapSave($data)
    {
        return $this->getDecodedSnapSave($this->decodeSnapApp($this->getEncodedSnapApp($data)));
    }
}
