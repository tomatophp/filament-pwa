<?php

namespace TomatoPHP\FilamentPWA\Services;

use Illuminate\Support\Facades\File;
use TomatoPHP\FilamentPWA\Settings\PWASettings;
use TomatoPHP\FilamentPWA\Support\PwaAsset;

class ManifestService
{
    public const ICON_SIZES = ['72x72', '96x96', '128x128', '144x144', '152x152', '192x192', '384x384', '512x512'];

    public const SPLASH_SIZES = ['640x1136', '750x1334', '828x1792', '1125x2436', '1242x2208', '1242x2688', '1536x2048', '1668x2224', '1668x2388', '2048x2732'];

    public static function generate(): array
    {
        $setting = new PWASettings;

        $splash = [];
        foreach (self::SPLASH_SIZES as $size) {
            $splash[$size] = PwaAsset::url($setting->{'pwa_splash_'.$size}, "/images/icons/splash-{$size}.png");
        }

        $icons = [];
        foreach (self::ICON_SIZES as $size) {
            $path = $setting->{'pwa_icons_'.$size};

            $icons[] = [
                'src' => PwaAsset::url($path, "/images/icons/icon-{$size}.png"),
                'type' => PwaAsset::mime($path),
                'sizes' => $size,
                'purpose' => 'any',
            ];
        }

        $manifest = [
            'name' => $setting->pwa_app_name,
            'short_name' => $setting->pwa_short_name,
            'start_url' => asset($setting->pwa_start_url),
            'display' => $setting->pwa_display,
            'theme_color' => $setting->pwa_theme_color,
            'background_color' => $setting->pwa_background_color,
            'orientation' => $setting->pwa_orientation,
            'status_bar' => $setting->pwa_status_bar,
            'splash' => $splash,
            'icons' => $icons,
        ];

        foreach ($setting->pwa_shortcuts ?? [] as $shortcut) {
            $shortcutManifest = [
                'name' => trans($shortcut['name'] ?? ''),
                'description' => trans($shortcut['description'] ?? ''),
                'url' => $shortcut['url'] ?? '/',
            ];

            if (filled($shortcut['icon'] ?? null)) {
                $shortcutManifest['icons'] = [[
                    'src' => PwaAsset::url($shortcut['icon'], ''),
                    'type' => PwaAsset::mime($shortcut['icon']),
                    'sizes' => '72x72',
                    'purpose' => 'any',
                ]];
            }

            $manifest['shortcuts'][] = $shortcutManifest;
        }

        return $manifest;
    }

    /**
     * The service worker script with the current icons in its offline cache list.
     */
    public static function serviceWorker(): string
    {
        $icons = collect(static::generate()['icons'])
            ->map(fn (array $icon): string => "    '".$icon['src']."'")
            ->implode(",\n");

        return str_replace('ICONS', $icons, File::get(__DIR__.'/../../resources/js/serviceworker.js'));
    }

    /**
     * Write the service worker to public/serviceworker.js, for apps that serve it as a static file.
     */
    public static function publishServiceWorker(): void
    {
        File::put(public_path('serviceworker.js'), static::serviceWorker());
    }
}
