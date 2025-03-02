<?php

namespace App\Http\Controllers\Web\Core\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AnimeWatchHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Concurrency;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        [$totalUsers, $totalActiveUsers, $totalWatchedAnimes, $newUsersChart] = Concurrency::run([
            fn () => User::count(),
            fn () => User::whereDate('last_login_at', today())->count(),
            fn () => AnimeWatchHistory::whereDate('updated_at', today())->count(),
            fn () => $this->getNewUsersChartData(),
        ]);

        $data = [
            'totalUsers' => $totalUsers,
            'totalActiveUsers' => $totalActiveUsers,
            'totalWatchedAnimes' => $totalWatchedAnimes,
            'newUsersChart' => $newUsersChart,
        ];

        return view('core.dashboard.index', $data);
    }

    private function getNewUsersChartData(): array
    {
        $stats = User::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(fn ($item) => [
                'date' => Carbon::parse($item->date)->format('d M Y'),
                'total' => $item->total,
            ]);

        return [
            'data' => $stats->pluck('total')->toArray(),
            'labels' => $stats->pluck('date')->toArray(),
        ];
    }
}
