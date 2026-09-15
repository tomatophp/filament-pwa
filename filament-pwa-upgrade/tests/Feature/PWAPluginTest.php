<?php

use Filament\Panel;
use TomatoPHP\FilamentPWA\Filament\Pages\PWASettingsPage;
use TomatoPHP\FilamentPWA\FilamentPWAPlugin;

beforeEach(function () {
    PWASettingsPage::$shouldRegisterNavigation = true;
});

test('plugin can be registered on panel', function () {
    $panel = Panel::make()->id('admin');

    $plugin = FilamentPWAPlugin::make();

    expect($plugin->getId())->toBe('filament-pwa');

    $plugin->register($panel);

    expect($panel->getPages())->toContain(PWASettingsPage::class);
});

test('plugin can disable PWA settings', function () {
    $panel = Panel::make()->id('admin');

    $plugin = FilamentPWAPlugin::make()
        ->allowPWASettings(false);

    $plugin->register($panel);

    expect($panel->getPages())->not->toContain(PWASettingsPage::class);
});
