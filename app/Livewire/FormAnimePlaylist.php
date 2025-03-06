<?php

namespace App\Livewire;

use App\Models\AnimePlaylist;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class FormAnimePlaylist extends Component
{
    public string $search = '';

    public array $animes = [];

    public array $savedAnimes = [];

    public bool $isMyPlaylist = false;

    public AnimePlaylist $playlist;

    public function render()
    {
        return view('livewire.form-anime-playlist');
    }

    public function mount(): void
    {
        if ($this->search) {
            $this->searchAnime();
        } else {
            $this->animes = [];
        }

        $this->savedAnimes = $this->playlist->data ?? [];
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

    public function updatedSavedAnimes(): void
    {
        $this->playlist->data = $this->savedAnimes;
        $this->playlist->save();
    }

    public function add(string $animeId): void
    {
        $filteredAnimes = array_filter($this->animes, function ($item) use ($animeId) {
            return $item['animeId'] == $animeId;
        });

        $anime = ! empty($filteredAnimes) ? reset($filteredAnimes) : null;

        $this->savedAnimes[] = $anime;

        $this->updatedSavedAnimes();
    }

    public function delete(string $animeId): void
    {
        $this->savedAnimes = array_filter($this->savedAnimes, function ($item) use ($animeId) {
            return $item['animeId'] != $animeId;
        });

        $this->updatedSavedAnimes();
    }

    public function toggleIsPublic(): void
    {
        $this->playlist->is_public = ! $this->playlist->is_public;
        $this->playlist->save();
    }
}
