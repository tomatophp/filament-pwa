<?php

namespace TomatoPHP\FilamentPWA;

use Illuminate\Support\ServiceProvider;


class FilamentPwaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register generate command
        $this->commands([
           \TomatoPHP\FilamentPWA\Console\FilamentPwaInstall::class,
        ]);

        //Register Config file
        $this->mergeConfigFrom(__DIR__.'/../config/filament-pwa.php', 'filament-pwa');

        //Publish Config
        $this->publishes([
           __DIR__.'/../config/filament-pwa.php' => config_path('filament-pwa.php'),
        ], 'filament-pwa-config');

        //Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-pwa');

        //Publish Views
        $this->publishes([
           __DIR__.'/../resources/views' => resource_path('views/vendor/filament-pwa'),
        ], 'filament-pwa-views');

        //Register Langs
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-pwa');

        //Publish Lang
        $this->publishes([
           __DIR__.'/../resources/lang' => base_path('lang/vendor/filament-pwa'),
        ], 'filament-pwa-lang');

    }

    public function boot(): void
    {
        //you boot methods here
    }
}
