<?php

namespace App\Http\Controllers\Web\Public\Gachamon;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class GachamonController extends Controller
{
    public function index(): View
    {
        return view('public.gachamon.index');
    }
}
