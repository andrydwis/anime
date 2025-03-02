<?php

namespace App\Http\Controllers\Web\Core\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AnimeWatchHistory;
use App\Models\User;
use Illuminate\Support\Facades\Concurrency;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        [$totalUsers, $totalActiveUsers, $totalWatchedAnimes] = Concurrency::run([
            fn () => User::count(),
            fn () => User::whereDate('last_login_at', today())->count(),
            fn () => AnimeWatchHistory::whereDate('updated_at', today())->count(),
        ]);

        $data = [
            'totalUsers' => $totalUsers,
            'totalActiveUsers' => $totalActiveUsers,
            'totalWatchedAnimes' => $totalWatchedAnimes,
        ];

        return view('core.dashboard.index', $data);
    }
}
