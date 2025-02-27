<?php

namespace App\Http\Controllers\Web\Public\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $home = Cache::remember('home', now()->addMinutes(5), function () {
            return Http::get(config('app.api_url').'/samehadaku/home')->json();
        });

        $data = [
            'home' => $home,
        ];

        return view('public.home.index', $data);
    }
}
