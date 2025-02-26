<?php

namespace App\Http\Controllers\Web\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $home = Http::get(config('app.api_url').'/otakudesu/home')->json();

        $data = [
            'home' => $home,
        ];
        //
        // dd($data);

        return view('index', $data);
    }
}
