<?php

namespace TomatoPHP\FilamentPWA\Support;

use Illuminate\Support\Facades\Storage;

class PwaAsset
{
    public static function disk(): string
    {
        return config('filament-pwa.upload_disk');
    }

    public static function url(?string $path, string $fallback): string
    {
        if (!$path) {
            return $fallback;
        }

        $disk = static::disk();

        if ($disk === 'public') {
            return ltrim($path, '/');
        }

        return Storage::disk($disk)->url($path);
    }

    public static function mime(?string $path): string
    {
        if (!$path) {
            return 'image/png';
        }

        $mime = Storage::disk(static::disk())->mimeType($path);

        return $mime ?: 'image/png';
    }
}