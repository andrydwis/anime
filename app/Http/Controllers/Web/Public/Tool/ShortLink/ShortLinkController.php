<?php

namespace App\Http\Controllers\Web\Public\Tool\ShortLink;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ShortLinkController extends Controller
{
    public function index(): View
    {
        return view('public.tool.short-link.index');
    }

    public function show(Link $link): View
    {
        if ($link->user_id != Auth::id()) {
            abort(403);
        }

        $data = [
            'link' => $link,
        ];

        return view('public.tool.short-link.show', $data);
    }
}
