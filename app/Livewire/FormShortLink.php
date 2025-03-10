<?php

namespace App\Livewire;

use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FormShortLink extends Component
{
    public $name;

    public $link;

    public $customLink;

    public $password;

    public $expiredAt;

    public $generatedLink;

    public $shortLinks;

    public function render(): View
    {
        return view('livewire.form-short-link');
    }

    public function mount(): void
    {
        $this->shortLinks = Link::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
    }

    public function generate(): void
    {
        $this->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'link' => ['required', 'string', 'active_url'],
            'customLink' => ['nullable', 'string', 'alpha_dash'],
            'password' => ['nullable', 'string', 'min:8'],
            'expiredAt' => ['nullable', 'date', Rule::date()->after(now())],
        ]);

        if ($this->customLink) {
            $generatedLink = $this->customLink;
            if (! $this->isShortUrlAvailable($generatedLink)) {
                // thow error bag to customLink
                $this->addError('customLink', 'Custom link sudah digunakan, coba yang lain.');

                return;
            }
        } else {
            $generatedLink = Str::random(8);
        }

        $link = new Link;
        $link->user_id = Auth::id();
        $link->uuid = Str::uuid();
        $link->name = $this->name ?? 'Short Link '.Carbon::now()->format('dmY');
        $link->original_link = $this->link;
        $link->link = $generatedLink;
        $link->password = $this->password;
        $link->expired_at = $this->expiredAt;
        $link->save();

        session()->flash('success', 'Short link berhasil dibuat 🎉.');

        $this->generatedLink = route('links.show', ['link' => $link]);

        $this->reset(['link', 'customLink', 'password', 'expiredAt']);

        $this->mount();
    }

    public function isShortUrlAvailable($shortUrl)
    {
        $shortUrl = trim($shortUrl, '/');

        // Get all registered route paths
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return trim($route->uri(), '/');
        });

        // Check for exact route matches
        if ($routes->contains($shortUrl)) {
            return false;
        }

        // Check for partial matches with static routes
        $staticRoutes = $routes->filter(fn ($uri) => ! str_contains($uri, '{'));

        if ($staticRoutes->contains(fn ($uri) => str_starts_with($shortUrl, $uri.'/'))) {
            return false;
        }

        // Check database for existing short links
        if (Link::where('link', $shortUrl)->exists()) {
            return false;
        }

        return true;
    }

    public function downloadQrCode(): BinaryFileResponse
    {
        $response = Http::get('https://api.qrserver.com/v1/create-qr-code/?size=150x150&format=png&data='.$this->generatedLink)->body();

        // set filename
        $filename = 'qrcode-'.Str::random(8).'.png';

        // save to storage
        Storage::put('qr-codes/'.$filename, $response);
        $path = Storage::path('qr-codes/'.$filename);

        return response()->download($path, $filename)->deleteFileAfterSend(true);
    }
}
