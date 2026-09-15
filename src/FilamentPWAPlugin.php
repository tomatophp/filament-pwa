<?php

namespace TomatoPHP\FilamentPWA;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use TomatoPHP\FilamentPWA\Filament\Pages\PWASettingsPage;
use TomatoPHP\FilamentPWA\Services\ManifestService;
use TomatoPHP\FilamentSettingsHub\Facades\FilamentSettingsHub;
use TomatoPHP\FilamentSettingsHub\FilamentSettingsHubPlugin;
use TomatoPHP\FilamentSettingsHub\Services\Contracts\SettingHold;

class FilamentPWAPlugin implements Plugin
{
    /**
     * Per plugin instance, so disabling the settings page on one panel does not disable it on the others.
     */
    protected bool $allowPWASettings = true;

    public function allowPWASettings(bool $allow = true): static
    {
        $this->allowPWASettings = $allow;

        return $this;
    }

    public function isSettingAllowed(): bool
    {
        return $this->allowPWASettings;
    }

    public function getId(): string
    {
        return 'filament-pwa';
    }

    public function register(Panel $panel): void
    {
        if (! $this->isSettingAllowed()) {
            return;
        }

        $panel->pages([PWASettingsPage::class]);

        // The settings page lives in the settings hub; add the hub unless the panel already registers it.
        if (! $panel->hasPlugin('filament-settings-hub')) {
            $panel->plugin(FilamentSettingsHubPlugin::make());
        }
    }

    public function boot(Panel $panel): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_END,
            fn () => view('filament-pwa::meta', ['config' => ManifestService::generate()])
        );

        if ($this->isSettingAllowed()) {
            FilamentSettingsHub::register([
                SettingHold::make()
                    ->label('filament-pwa::messages.settings.title')
                    ->icon('heroicon-o-sparkles')
                    ->page(PWASettingsPage::class)
                    ->description('filament-pwa::messages.settings.description')
                    ->group('filament-settings-hub::messages.group'),
            ]);
        }
    }

    public static function make(): static
    {
        return app(static::class);
    }
}
