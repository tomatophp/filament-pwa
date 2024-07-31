<?php

namespace TomatoPHP\FilamentPWA;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use TomatoPHP\FilamentSettingsHub\FilamentSettingsHubPlugin;


class FilamentPWAPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-pwa';
    }

    public function register(Panel $panel): void
    {
        $panel->plugin(FilamentSettingsHubPlugin::make());
    }

    public function boot(Panel $panel): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_END,
            fn () => Blade::render('@laravelPWA')
        );
    }

    public static function make(): static
    {
        return new static();
    }
}
