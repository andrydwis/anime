<?php

namespace App\Http\Controllers\Web\Public\Tool\ShortLink;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RedirectShortLinkController extends Controller
{
    public function show(Link $link): View|RedirectResponse
    {
        $data = [
            'link' => $link,
        ];

        if ($link->expired_at && Carbon::now()->gt($link->expired_at)) {
            return view('public.tool.short-link.expired', $data);
        }

        if ($link->password) {
            return view('public.tool.short-link.password', $data);
        }

        return redirect($link->original_link);
    }

    public function authenticate(Link $link, Request $request): RedirectResponse
    {
        if ($link->password === $request->password) {
            return redirect($link->original_link);
        }

        return back()->withErrors([
            'password' => 'Password tidak sesuai',
        ]);
    }
}
