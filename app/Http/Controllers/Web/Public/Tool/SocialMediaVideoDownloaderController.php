<?php

namespace App\Http\Controllers\Web\Public\Tool;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SocialMediaVideoDownloaderController extends Controller
{
    public function index()
    {
        return view('public.tool.social-media-video-downloader.index');
    }
}
