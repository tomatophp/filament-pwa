<?php

namespace TomatoPHP\FilamentPWA\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use TomatoPHP\FilamentPWA\Services\ManifestService;

class PWAController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(ManifestService::generate());
    }

    public function offline(): View
    {
        return view('filament-pwa::offline');
    }

    public function serviceWorker(): Response
    {
        return response(ManifestService::serviceWorker())
            ->header('Content-Type', 'application/javascript')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
