<?php

use Illuminate\Support\Facades\Route;

Route::group(['as' => 'pwa.'], function()
{
    Route::get('/manifest.json', [\TomatoPHP\FilamentPWA\Http\Controllers\PWAController::class, 'index'])->name('manifest');
    Route::get('/offline/', [\TomatoPHP\FilamentPWA\Http\Controllers\PWAController::class, 'offline'])->name('offline');
});
