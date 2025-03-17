<?php

namespace App\Livewire;

use App\Helpers\FacebookVideoDownloader;
use App\Helpers\TiktokVideoDownloader;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

class SocialMediaVideoDownloader extends Component
{
    #[Url]
    public string $url = '';

    public string $socialMedia = '';

    public array $data = [];

    public function render(): View
    {
        return view('livewire.social-media-video-downloader');
    }

    public function download(): void
    {
        if (Str::contains($this->url, 'facebook.com') || Str::contains($this->url, 'fb.watch')) {
            $this->socialMedia = 'facebook';
            $this->data = FacebookVideoDownloader::parse($this->url);
        } elseif (Str::contains($this->url, 'tiktok.com')) {
            $this->socialMedia = 'tiktok';
            $this->data = TiktokVideoDownloader::parse($this->url);
        } else {
            $this->socialMedia = '';
            $this->data = [];
            $this->addError('url', 'Untuk sekarang hanya support Facebook.');
        }
    }

    public function downloadTiktokVideo(string $url)
    {
        $fileName = 'videos/'.$this->data['data']['title'].'.mp4';
        $file = Storage::disk('public')->put($fileName, file_get_contents($url));

        if (! $file) {
            $this->addError('url', 'Gagal mendownload video.');

            return;
        }
        $filePath = Storage::disk('public')->path($fileName);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
