<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

include __DIR__.'/public.php';
include __DIR__.'/auth.php';
include __DIR__.'/core.php';

Route::get('{link:link}', [App\Http\Controllers\Web\Public\Tool\ShortLink\RedirectShortLinkController::class, 'show'])->name('links.show')->missing(function (Request $request) {
    return abort(404);
});
Route::post('{link:link}', [App\Http\Controllers\Web\Public\Tool\ShortLink\RedirectShortLinkController::class, 'authenticate'])->name('links.authenticate')->missing(function (Request $request) {
    return abort(404);
});
