<?php

namespace App\Livewire;

use App\Models\Link;
use App\Models\LogLink;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StatShortLink extends Component
{
    public Link $linkData;

    public $name;

    public $link;

    public $customLink;

    public $password;

    public $expiredAt;

    public $generatedLink;

    public bool $isEdit = false;

    public int $totalVisits = 0;

    public int $totalUniqueVisitors = 0;

    public array $topCountryCities = [];

    public function render(): View
    {
        return view('livewire.stat-short-link');
    }

    public function mount(): void
    {
        $this->name = $this->linkData->name;
        $this->link = $this->linkData->original_link;
        $this->customLink = $this->linkData->link;
        $this->password = $this->linkData->password;
        $this->expiredAt = $this->linkData->expired_at;
        $this->generatedLink = route('links.show', ['link' => $this->linkData]);

        $this->totalVisits = LogLink::select(DB::raw('count(*) as total'))->where('link_id', $this->linkData->id)->first()->total;
        $this->totalUniqueVisitors = LogLink::select(DB::raw('count(distinct ip) as total'))->where('link_id', $this->linkData->id)->first()->total;

        $this->topCountryCities = LogLink::select(DB::raw('country_name, city, count(*) as total'))
            ->where('link_id', $this->linkData->id)
            ->groupBy('country_name', 'city')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get()->toArray();
    }

    public function toggleIsEdit(): void
    {
        $this->isEdit = ! $this->isEdit;
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

        $link = $this->linkData;
        $link->name = $this->name ?? 'Short Link '.Carbon::now()->format('dmY');
        $link->original_link = $this->link;
        $link->link = $generatedLink;
        $link->password = $this->password;
        $link->expired_at = $this->expiredAt;
        $link->save();

        session()->flash('success', 'Short link berhasil diperbarui 🎉.');

        $this->generatedLink = route('links.show', ['link' => $link]);
        $this->customLink = $generatedLink;

        $this->toggleIsEdit();
    }

    public function isShortUrlAvailable(string $shortUrl)
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
        if (Link::where('link', $shortUrl)->where('id', '!=', $this->linkData->id)->exists()) {
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
