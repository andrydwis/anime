<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

class SeachModal extends Component
{
    #[Url]
    public string $search = '';

    public array $animes = [];

    public function render(): View
    {
        return view('livewire.seach-modal');
    }

    public function mount(): void
    {
        if ($this->search) {
            $this->searchAnime();
        } else {
            $this->animes = [];
        }
    }

    public function updatedSearch(): void
    {
        if ($this->search) {
            $this->searchAnime();
        } else {
            $this->animes = [];
        }
    }

    public function searchAnime(): void
    {
        $animes = Http::get(config('app.api_url').'/samehadaku/search', ['q' => $this->search])->json();

        $this->animes = $animes['data']['animeList'] ?? [];
    }
}
