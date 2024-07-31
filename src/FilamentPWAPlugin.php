<?php

namespace TomatoPHP\FilamentPWA;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use TomatoPHP\FilamentPWA\Filament\Pages\PWASettingsPage;
use TomatoPHP\FilamentPWA\Services\ManifestService;
use TomatoPHP\FilamentPWA\Settings\PWASettings;
use TomatoPHP\FilamentSettingsHub\Facades\FilamentSettingsHub;
use TomatoPHP\FilamentSettingsHub\FilamentSettingsHubPlugin;
use TomatoPHP\FilamentSettingsHub\Services\Contracts\SettingHold;


class FilamentPWAPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-pwa';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->pages([
                PWASettingsPage::class
            ])
            ->plugin(FilamentSettingsHubPlugin::make());
    }

    public function boot(Panel $panel): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_END,
            fn () => view('filament-pwa::meta', ['config' => ManifestService::generate()])
        );

        FilamentSettingsHub::register([
            SettingHold::make()
                ->label('filament-pwa::messages.settings.title')
                ->icon('heroicon-o-sparkles')
                ->route('filament.'.filament()->getCurrentPanel()->getId().'.pages.pwa-settings-page')
                ->description('filament-pwa::messages.settings.description')
                ->group('filament-settings-hub::messages.group'),
        ]);
    }

    public static function make(): static
    {
        return new static();
    }
}
