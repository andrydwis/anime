<?php

namespace App\Http\Controllers\Web\Public\Anime;

use App\Http\Controllers\Controller;
use App\Models\AnimeWatchHistory;
use App\Models\AnimeWatchlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ListAnimeController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $watchlists = AnimeWatchlist::where('user_id', $user->id)->get();

        // group by date updated_at day
        $histories = AnimeWatchHistory::where('user_id', $user->id)->orderBy('updated_at', 'desc')->limit(24)->get()->groupBy(function ($history) {
            return $history->updated_at->isoFormat('DD MMM YYYY');
        });

        $data = [
            'watchlists' => $watchlists,
            'histories' => $histories,
        ];

        return view('public.anime.list.index', $data);
    }
}
