<?php

namespace App\Livewire;

use App\Models\AnimePlaylist;
use App\Models\AnimeWatchlist;
use Carbon\Carbon;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

class SaveAnime extends Component
{
    public string $animeId;

    public array $anime;

    public string $episodeId;

    public ?AnimeWatchlist $animeWatchlist;

    public array $animePlaylists;

    public string $playlistName;

    public function render(): View
    {
        return view('livewire.save-anime');
    }

    public function mount(): void
    {
        if (Auth::check()) {
            $user = Auth::user();

            $this->animeWatchlist = AnimeWatchlist::where('user_id', $user->id)->where('anime_id', $this->animeId)->first();

            $this->animePlaylists = AnimePlaylist::where('user_id', $user->id)->get()->toArray();
        }
    }

    public function save()
    {
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

    public function removeFromPlaylist(int $playlistId): void
    {
        $animePlaylist = AnimePlaylist::find($playlistId);
        $animePlaylist->data = array_filter($animePlaylist->data, function ($anime) {
            return $anime['animeId'] !== $this->animeId;
        });
        $animePlaylist->save();

        $this->animePlaylists = AnimePlaylist::where('user_id', Auth::user()->id)->get()->toArray();
    }

    public function saveToPlaylist(int $playlistId): void
    {
        // Find the playlist
        $animePlaylist = AnimePlaylist::find($playlistId);

        // Retrieve the current data as an array
        $data = $animePlaylist->data ?? [];

        // upsert the anime data
        $anime = $this->anime['data'];
        $anime['animeId'] = $this->animeId;
        $anime['title'] = $this->anime['data']['synonyms'];

        // Remove duplicates based on animeId
        $data = array_filter($data, function ($item) use ($anime) {
            return $item['animeId'] !== $anime['animeId'];
        });
        // Add new anime data
        $data[] = $anime;

        // Reassign the modified data back to the model
        $animePlaylist->data = $data;

        // Save the changes
        $animePlaylist->save();

        // Refresh the playlists for the user
        $this->animePlaylists = AnimePlaylist::where('user_id', Auth::user()->id)->get()->toArray();
    }

    public function saveToNewPlaylist(): void
    {
        $this->validate([
            'playlistName' => ['required', 'string', 'max:255'],
        ]);

        $playlist = new AnimePlaylist;
        $playlist->user_id = Auth::id();
        $playlist->name = $this->playlistName;
        $playlist->slug = Str::slug($this->playlistName).'-'.Carbon::now()->format('dmY');
        $playlist->save();

        $this->saveToPlaylist($playlist->id);
        $this->playlistName = '';

        Flux::modal('add-playlist')->close();
    }
}
