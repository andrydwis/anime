<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use App\Services\Scraper\HomeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(): JsonResponse
    {
        $data = Cache::remember('home', now()->addMinutes(5), function () {
            return HomeService::scrapeHome();
        });

        return response()->json($data);
    }
}
