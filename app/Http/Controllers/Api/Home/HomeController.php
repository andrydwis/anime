<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use App\Services\Scraper\HomeService;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function index(): JsonResponse
    {
        $data = HomeService::scrapeHome();

        return response()->json($data);
    }
}
