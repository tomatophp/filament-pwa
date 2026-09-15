<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use TomatoPHP\FilamentPWA\Services\ManifestService;
use TomatoPHP\FilamentPWA\Support\PwaAsset;

function useCdnDisk(): void
{
    config()->set('filesystems.disks.cdn', [
        'driver' => 'local',
        'root' => storage_path('framework/testing/disks/cdn'),
        'url' => 'https://cdn.example.com',
    ]);
    config()->set('filament-pwa.upload_disk', 'cdn');
}

test('an empty path uses the fallback', function () {
    expect(PwaAsset::url(null, '/images/icons/icon-72x72.png'))->toBe('/images/icons/icon-72x72.png')
        ->and(PwaAsset::url('', '/fallback.png'))->toBe('/fallback.png');
});

test('the public disk keeps the /storage path', function () {
    expect(PwaAsset::disk())->toBe('public')
        ->and(PwaAsset::url('pwa/icon.png', '/fallback.png'))->toBe('/storage/pwa/icon.png')
        ->and(PwaAsset::url('/pwa/icon.png', '/fallback.png'))->toBe('/storage/pwa/icon.png');
});

test('another disk builds the url from that disk', function () {
    useCdnDisk();

    expect(PwaAsset::url('pwa/icon.png', '/fallback.png'))->toBe('https://cdn.example.com/pwa/icon.png');
});

test('an unset disk falls back to public', function () {
    config()->set('filament-pwa.upload_disk', null);

    expect(PwaAsset::disk())->toBe('public');
});

test('the mime type is read from the disk and falls back to png', function () {
    Storage::fake('public');
    Storage::disk('public')->put('pwa/icon.gif', base64_decode('R0lGODlhAQABAAAAACwAAAAAAQABAAA='));

    expect(PwaAsset::mime('pwa/icon.gif'))->toBe('image/gif')
        ->and(PwaAsset::mime('pwa/missing.png'))->toBe('image/png')
        ->and(PwaAsset::mime(null))->toBe('image/png');
});

test('the manifest uses the configured disk for uploaded icons', function () {
    useCdnDisk();

    DB::table('settings')
        ->where('group', 'pwa')
        ->where('name', 'pwa_icons_512x512')
        ->update(['payload' => json_encode('pwa/icon-512.png')]);

    $icons = collect(ManifestService::generate()['icons'])->keyBy('sizes');

    expect($icons['512x512']['src'])->toBe('https://cdn.example.com/pwa/icon-512.png')
        ->and($icons['72x72']['src'])->toBe('/images/icons/icon-72x72.png');
});
