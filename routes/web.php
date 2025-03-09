<?php

use App\Models\Link;
use Illuminate\Support\Facades\Route;

include __DIR__.'/public.php';
include __DIR__.'/auth.php';
include __DIR__.'/core.php';

Route::get('{link:link}', function (Link $link) {
    return redirect($link->original_link);
})->name('links.show');
