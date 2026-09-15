<?php

use Filament\Panel;
use Illuminate\Routing\RouteCollection;
use Tests\Models\User;
use TomatoPHP\FilamentPWA\Filament\Pages\PWASettingsPage;
use TomatoPHP\FilamentPWA\FilamentPWAPlugin;
use TomatoPHP\FilamentPWA\Services\ManifestService;
use TomatoPHP\FilamentSettingsHub\FilamentSettingsHubPlugin;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('plugin can be registered on panel', function () {
    $panel = Panel::make()->id('pwa-test');

    $plugin = FilamentPWAPlugin::make();

    expect($plugin->getId())->toBe('filament-pwa');

    $plugin->register($panel);

    expect($panel->getPages())->toContain(PWASettingsPage::class);
});

test('plugin can disable PWA settings', function () {
    $panel = Panel::make()->id('pwa-test');

    FilamentPWAPlugin::make()
        ->allowPWASettings(false)
        ->register($panel);

    expect($panel->getPages())->not->toContain(PWASettingsPage::class);
});

test('disabling the settings page on one panel keeps it on the others', function () {
    $withoutSettings = Panel::make()->id('without-settings');
    $withSettings = Panel::make()->id('with-settings');

    FilamentPWAPlugin::make()->allowPWASettings(false)->register($withoutSettings);
    FilamentPWAPlugin::make()->register($withSettings);

    expect($withoutSettings->getPages())->not->toContain(PWASettingsPage::class)
        ->and($withSettings->getPages())->toContain(PWASettingsPage::class);
});

test('plugin keeps the settings hub plugin the panel already has', function () {
    $hub = FilamentSettingsHubPlugin::make();
    $panel = Panel::make()->id('pwa-test')->plugin($hub);

    FilamentPWAPlugin::make()->register($panel);

    expect($panel->getPlugin('filament-settings-hub'))->toBe($hub);
});

test('the panel renders the pwa meta tags', function () {
    actingAs(User::factory()->create());

    get('/admin')
        ->assertSuccessful()
        ->assertSee('rel="manifest"', false)
        ->assertSee('apple-mobile-web-app-title', false)
        ->assertSee('/serviceworker.js', false);
});

test('the meta tags render when the pwa routes are disabled', function () {
    // filament-pwa.allow_routes = false: the manifest route is never registered.
    app('router')->setRoutes(new RouteCollection);

    $html = view('filament-pwa::meta', ['config' => ManifestService::generate()])->render();

    expect($html)->toContain('apple-mobile-web-app-title')
        ->not->toContain('rel="manifest"');
});
