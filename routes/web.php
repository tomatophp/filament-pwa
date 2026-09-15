<?php

use Illuminate\Support\Facades\Route;
use TomatoPHP\FilamentPWA\Http\Controllers\PWAController;

if (config('filament-pwa.allow_routes')) {
    Route::middleware(config('filament-pwa.middlewares'))->as('pwa.')->group(function () {
        Route::get('/manifest.json', [PWAController::class, 'index'])->name('manifest');
        Route::get('/offline/', [PWAController::class, 'offline'])->name('offline');
        Route::get('/serviceworker.js', [PWAController::class, 'serviceWorker'])->name('serviceworker');
    });
}
