<?php

namespace App\Http\Controllers\Web\Public\Animex;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class AnimexController extends Controller
{
    public function index(): View
    {
        $home = Http::get(config('app.beta_api_url') . '/aniwatch')->json();

        $data = [
            'home' => $home,
        ];

        return view('public.animex.index', $data);
    }
}
