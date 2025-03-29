<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\Web\Public\Home\HomeController::class, 'index'])->name('home');

Route::get('anime', [App\Http\Controllers\Web\Public\Anime\AnimeController::class, 'index'])->name('anime.index');
Route::get('anime/recent', [App\Http\Controllers\Web\Public\Anime\RecentAnimeController::class, 'index'])->name('anime.recent.index');

Route::get('anime/genre/{genre}', [App\Http\Controllers\Web\Public\Anime\GenreAnimeController::class, 'show'])->name('anime.genre.show');

Route::get('anime/list', [App\Http\Controllers\Web\Public\Anime\ListAnimeController::class, 'index'])->name('anime.list.index')->middleware(['auth']);
Route::post('anime/list', [App\Http\Controllers\Web\Public\Anime\ListAnimeController::class, 'store'])->name('anime.list.store')->middleware(['auth']);
Route::get('anime/list/{playlist:slug}', [App\Http\Controllers\Web\Public\Anime\ListAnimeController::class, 'show'])->name('anime.list.show')->middleware(['auth']);
Route::patch('anime/list/{playlist:slug}', [App\Http\Controllers\Web\Public\Anime\ListAnimeController::class, 'update'])->name('anime.list.update')->middleware(['auth']);
Route::delete('anime/list/{playlist:slug}', [App\Http\Controllers\Web\Public\Anime\ListAnimeController::class, 'destroy'])->name('anime.list.destroy')->middleware(['auth']);

Route::get('anime/{anime}', [App\Http\Controllers\Web\Public\Anime\AnimeController::class, 'show'])->name('anime.show');
Route::get('anime/{anime}/episode/{episode}', [App\Http\Controllers\Web\Public\Anime\EpisodeController::class, 'show'])->name('anime.episode.show');

Route::get('manga', [App\Http\Controllers\Web\Public\Manga\MangaController::class, 'index'])->name('manga.index');
Route::get('manga/{manga}', [App\Http\Controllers\Web\Public\Manga\MangaController::class, 'show'])->name('manga.show');
Route::get('manga/{mangaId}/chapter/{chapterId}', [App\Http\Controllers\Web\Public\Manga\MangaController::class, 'read'])->name('manga.read');

Route::get('gachamon', [App\Http\Controllers\Web\Public\Gachamon\GachamonController::class, 'index'])->name('gachamon.index')->middleware(['auth']);
Route::get('gachamon/{gachamon}', [App\Http\Controllers\Web\Public\Gachamon\GachamonController::class, 'show'])->name('gachamon.show')->middleware(['auth']);

Route::resource('news', App\Http\Controllers\Web\Public\News\NewsController::class)->scoped(['news' => 'slug'])->only(['index', 'show']);
Route::resource('events', App\Http\Controllers\Web\Public\Event\EventController::class)->scoped(['event' => 'slug'])->only(['index', 'show']);

Route::get('profile', [App\Http\Controllers\Web\Public\Profile\ProfileController::class, 'edit'])->name('profile.edit')->middleware(['auth']);
Route::patch('profile', [App\Http\Controllers\Web\Public\Profile\ProfileController::class, 'update'])->name('profile.update')->middleware(['auth']);

Route::get('tools/short-links', [App\Http\Controllers\Web\Public\Tool\ShortLink\ShortLinkController::class, 'index'])->name('tools.short-links.index')->middleware(['auth']);
Route::get('tools/short-links/{link:uuid}', [App\Http\Controllers\Web\Public\Tool\ShortLink\ShortLinkController::class, 'show'])->name('tools.short-links.show')->whereUuid('link')->middleware(['auth']);
Route::get('tools/social-media-video-downloader', [App\Http\Controllers\Web\Public\Tool\SocialMediaVideoDownloaderController::class, 'index'])->name('tools.social-media-video-downloader.index')->middleware(['auth']);

Route::view('dmca', 'public.other.dmca')->name('dmca');
Route::view('privacy-policy', 'public.other.privacy')->name('privacy-policy');
Route::view('terms-of-service', 'public.other.tos')->name('terms-of-service');
