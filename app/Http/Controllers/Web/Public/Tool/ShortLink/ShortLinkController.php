<?php

namespace App\Http\Controllers\Web\Public\Tool\ShortLink;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShortLinkController extends Controller
{
    public function index(): View
    {
        return view('public.tool.short-link.index');
    }
}
