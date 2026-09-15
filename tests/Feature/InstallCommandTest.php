<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use function Pest\Laravel\artisan;

test('install publishes the settings migration, the icons and the service worker', function () {
    // A fresh app has no pwa settings yet; the published migration creates them.
    DB::table('settings')->where('group', 'pwa')->delete();

    $migrations = fn () => collect(File::files(database_path('migrations')))
        ->map(fn ($file): string => $file->getPathname())
        ->filter(fn (string $path): bool => str_contains($path, '_pwa_settings.php'));

    $hadImages = File::isDirectory(public_path('images'));

    try {
        artisan('filament-pwa:install')
            ->expectsOutputToContain('Filament PWA installed successfully.')
            ->assertSuccessful();

        expect($migrations())->toHaveCount(1)
            ->and(DB::table('settings')->where('group', 'pwa')->where('name', 'pwa_app_name')->exists())->toBeTrue()
            ->and(File::exists(public_path('images/icons/icon-512x512.png')))->toBeTrue()
            ->and(File::get(public_path('serviceworker.js')))->toContain("'/images/icons/icon-72x72.png'");

        // Running it again does not publish a second migration.
        artisan('filament-pwa:install')->assertSuccessful();

        expect($migrations())->toHaveCount(1);
    } finally {
        $migrations()->each(fn (string $path) => File::delete($path));
        File::delete(public_path('serviceworker.js'));

        if (! $hadImages) {
            File::deleteDirectory(public_path('images'));
        }
    }
});
