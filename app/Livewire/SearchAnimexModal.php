<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Url;
use Livewire\Component;

class SearchAnimexModal extends Component
{
    #[Url]
    public string $search = '';

    public array $animes = [];

    public function render()
    {
        return view('livewire.search-animex-modal');
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
        $animes = Http::get(config('app.beta_api_url').'/aniwatch/search', ['keyword' => $this->search])->json();

        $this->animes = $animes['animes'] ?? [];
    }
}
