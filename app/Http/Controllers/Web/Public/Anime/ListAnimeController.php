<?php

namespace App\Http\Controllers\Web\Public\Anime;

use App\Http\Controllers\Controller;
use App\Models\AnimePlaylist;
use App\Models\AnimeWatchHistory;
use App\Models\AnimeWatchlist;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ListAnimeController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $watchlists = AnimeWatchlist::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        // group by date updated_at day
        $histories = AnimeWatchHistory::where('user_id', $user->id)->orderBy('updated_at', 'desc')->limit(24)->get()->groupBy(function ($history) {
            return $history->updated_at->isoFormat('DD MMM YYYY');
        });

        $playlists = AnimePlaylist::where('user_id', $user->id)->get();

        $data = [
            'watchlists' => $watchlists,
            'histories' => $histories,
            'playlists' => $playlists,
        ];

        return view('public.anime.list.index', $data);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $playlist = new AnimePlaylist;
        $playlist->user_id = Auth::id();
        $playlist->name = $request->input('name');
        $playlist->slug = Str::slug($request->input('name')).'-'.Carbon::now()->format('dmY');
        $playlist->description = $request->input('description') ? Str::sanitizeHtml($request->input('description')) : null;
        $playlist->save();

        session()->flash('success', 'Playlist berhasil dibuat.');

        return redirect()->route('anime.list.show', ['playlist' => $playlist]);
    }

    public function show(AnimePlaylist $playlist): View
    {
        if (! $playlist->is_public && Auth::id() != $playlist->user_id) {
            abort(403);
        }

        $data = [
            'playlist' => $playlist,
            'isMyPlaylist' => Auth::check() && Auth::id() == $playlist->user_id,
        ];

        return view('public.anime.list.show', $data);
    }

    public function update(Request $request, AnimePlaylist $playlist): RedirectResponse
    {
        if (Auth::id() != $playlist->user_id) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $playlist->name = $request->input('name');
        $playlist->description = $request->input('description') ? Str::sanitizeHtml($request->input('description')) : null;
        $playlist->save();

        session()->flash('success', 'Playlist berhasil diperbarui.');

        return redirect()->back();
    }

    public function destroy(AnimePlaylist $playlist): RedirectResponse
    {
        if (Auth::id() != $playlist->user_id) {
            abort(403);
        }

        $playlist->delete();

        session()->flash('success', 'Playlist berhasil dihapus.');

        return redirect()->route('anime.list.index');
    }
}
