<?php

namespace App\Http\Controllers\Web\Core\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('core.dashboard.index');
    }
}
