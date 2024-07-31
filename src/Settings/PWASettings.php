<?php

namespace TomatoPHP\FilamentPWA\Settings;

use Spatie\LaravelSettings\Settings;


class PWASettings extends Settings
{
    public ?string $pwa_app_name;
    public ?string $pwa_short_name;
    public ?string $pwa_start_url;
    public ?string $pwa_background_color;
    public ?string $pwa_theme_color;
    public ?string $pwa_status_bar;
    public ?string $pwa_display;
    public ?string $pwa_orientation;
    public ?string $pwa_icons_72x72;
    public ?string $pwa_icons_96x96;
    public ?string $pwa_icons_128x128;
    public ?string $pwa_icons_144x144;
    public ?string $pwa_icons_152x152;
    public ?string $pwa_icons_192x192;
    public ?string $pwa_icons_384x384;
    public ?string $pwa_icons_512x512;
    public ?string $pwa_splash_640x1136;
    public ?string $pwa_splash_750x1334;
    public ?string $pwa_splash_828x1792;
    public ?string $pwa_splash_1125x2436;
    public ?string $pwa_splash_1242x2208;
    public ?string $pwa_splash_1242x2688;
    public ?string $pwa_splash_1536x2048;
    public ?string $pwa_splash_1668x2224;
    public ?string $pwa_splash_1668x2388;
    public ?string $pwa_splash_2048x2732;
    public ?array $pwa_shortcuts;

    public static function group(): string
    {
        return 'pwa';
    }
}
