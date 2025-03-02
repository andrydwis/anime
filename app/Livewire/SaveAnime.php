<?php

namespace App\Livewire;

use App\Models\AnimeWatchlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class SaveAnime extends Component
{
    public string $animeId;

    public array $anime;

    public string $episodeId;

    public ?AnimeWatchlist $animeWatchlist;

    public function render(): View
    {
        return view('livewire.save-anime');
    }

    public function mount(): void
    {
        if (Auth::check()) {
            $user = Auth::user();

            $this->animeWatchlist = AnimeWatchlist::where('user_id', $user->id)->where('anime_id', $this->animeId)->first();
        }
    }

    public function save()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $animeWatchlist = AnimeWatchlist::firstOrCreate([
            'user_id' => $user->id,
            'anime_id' => $this->animeId,
        ], [
            'data' => [
                'animeId' => $this->animeId,
                'anime' => $this->anime,
            ],
        ]);

        $this->animeWatchlist = $animeWatchlist;
    }

    public function remove(): void
    {
        $this->animeWatchlist->forceDelete();
        $this->animeWatchlist = null;
    }
}
