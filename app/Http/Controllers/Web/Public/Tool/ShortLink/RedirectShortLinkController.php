<?php

namespace App\Http\Controllers\Web\Public\Tool\ShortLink;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use ipinfo\ipinfo\IPinfo;

class RedirectShortLinkController extends Controller
{
    public function show(Link $link, Request $request): View|RedirectResponse
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

        if (config('app.env') != 'local') {
            $client = new IPinfo;
            $details = $client->getDetails($request->ip());

            $data = [
                'link_id' => $link->id,
                'ip' => $request->ip(),
                'referrer' => $request->headers->get('referer'),
                'user_agent' => $request->userAgent(),
                'country_code' => $details->country,
                'country_name' => $details->country_name,
                'city' => $details->city,
                'latitude' => $details->latitude,
                'longitude' => $details->longitude,
                'utm_source' => $request->query('utm_source'),
                'utm_medium' => $request->query('utm_medium'),
                'utm_campaign' => $request->query('utm_campaign'),
            ];

            $link->logs()->create($data);

            dd($data);
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
