<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

include __DIR__.'/public.php';
include __DIR__.'/auth.php';
include __DIR__.'/core.php';

Route::get('/proxy', function () {
    $url = request('url');
    if (! $url) {
        return response()->json(['error' => 'URL parameter is required'], 400);
    }

    try {
        $response = \Illuminate\Support\Facades\Http::get($url);

        // Log the response status and headers
        Log::info('Proxy Response Status:', ['status' => $response->status()]);
        Log::info('Proxy Response Headers:', ['headers' => $response->headers()]);

        return response($response->body())
            ->header('Content-Type', 'video/mp4')
            ->header('Access-Control-Allow-Origin', '*');
    } catch (\Exception $e) {
        Log::error('Proxy Error:', ['message' => $e->getMessage()]);

        return response()->json(['error' => 'Failed to fetch video'], 500);
    }
})->name('proxy');

Route::get('{link:link}', [App\Http\Controllers\Web\Public\Tool\ShortLink\RedirectShortLinkController::class, 'show'])->name('links.show')->missing(function (Request $request) {
    return abort(404);
});
Route::post('{link:link}', [App\Http\Controllers\Web\Public\Tool\ShortLink\RedirectShortLinkController::class, 'authenticate'])->name('links.authenticate')->missing(function (Request $request) {
    return abort(404);
});
