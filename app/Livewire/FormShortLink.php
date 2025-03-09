<?php

namespace App\Livewire;

use App\Models\Link;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class FormShortLink extends Component
{
    public $link;

    public $customLink;

    public $password;

    public $expiredAt;

    public $generatedLink;

    public function render(): View
    {
        return view('livewire.form-short-link');
    }

    public function generate(): void
    {
        $this->validate([
            'link' => ['required', 'string', 'active_url'],
            'customLink' => ['nullable', 'string', 'alpha_dash'],
            'password' => ['nullable', 'string', 'min:8'],
            'expiredAt' => ['nullable', 'date', Rule::date()->after(now())],
        ]);

        if ($this->customLink) {
            $exists = $this->routeUriExists($this->customLink);

            if ($exists) {
                // thow error bag to customLink
                $this->addError('customLink', 'Custom link sudah digunakan, coba yang lain.');

                return;
            }
        }

        $generatedLink = $customLink ?? Str::random(8);

        $link = new Link;
        $link->user_id = Auth::id();
        $link->uuid = Str::uuid();
        $link->original_link = $this->link;
        $link->link = $generatedLink;
        $link->password = $this->password;
        $link->expired_at = $this->expiredAt;
        $link->save();

        session()->flash('success', 'Short Link berhasil dibuat 🎉.');

        $this->generatedLink = route('links.show', ['link' => $link]);

        $this->reset(['link', 'customLink', 'password', 'expiredAt']);
    }

    public function routeUriExists(string $url): bool
    {
        $path = parse_url($url, PHP_URL_PATH);
        $routes = app('router')->getRoutes();

        foreach ($routes as $route) {
            $uri = $route->uri();
            // Convert route URI to regex pattern (basic parameter handling)
            $pattern = '@^'.preg_replace('/{.*?}/', '([^/]+)', $uri).'$@';
            if (preg_match($pattern, $path)) {
                return true;
            }
        }

        return false;
    }

    public function downloadQrCode()
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
