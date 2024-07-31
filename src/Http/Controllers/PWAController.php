<?php

namespace TomatoPHP\FilamentPWA\Http\Controllers;

use App\Http\Controllers\Controller;
use TomatoPHP\FilamentPWA\Services\ManifestService;

class PWAController extends Controller
{
    public function index()
    {
        return response()->json(ManifestService::generate());
    }

    public function offline()
    {
        return view('filament-pwa::offline');
    }
}
