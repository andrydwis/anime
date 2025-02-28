<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Url;
use Livewire\Component;

class SeachModal extends Component
{
    #[Url]
    public string $search = '';

    public array $animes = [];

    public function render()
    {
        return view('livewire.seach-modal');
    }

    public function mount(): void
    {
        $this->searchAnime();
    }

    public function updatedSearch(): void
    {
        $this->searchAnime();
    }

    public function searchAnime(): void
    {
        $animes = Http::get(config('app.api_url').'/samehadaku/search', ['q' => $this->search])->json();

        $this->animes = $animes['data']['animeList'] ?? [];
    }
}
