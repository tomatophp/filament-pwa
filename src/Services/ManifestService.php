<?php

namespace TomatoPHP\FilamentPWA\Services;

class ManifestService
{
    public static function generate()
    {
        $setting = new \TomatoPHP\FilamentPWA\Settings\PWASettings();
        $basicManifest =  [
            'name' => $setting->pwa_app_name,
            'short_name' => $setting->pwa_short_name,
            'start_url' => asset($setting->pwa_start_url),
            'display' => $setting->pwa_display,
            'theme_color' => $setting->pwa_theme_color,
            'background_color' => $setting->pwa_background_color,
            'orientation' => $setting->pwa_orientation,
            'status_bar' =>  $setting->pwa_status_bar,
            'splash' =>  [
                '640x1136' => $setting->pwa_splash_640x1136 ? '/storage/'.$setting->pwa_splash_640x1136 : "/images/icons/splash-640x1136.png",
                '750x1334' => $setting->pwa_splash_750x1334 ? '/storage/'.$setting->pwa_splash_750x1334 : "/images/icons/splash-750x1334.png",
                '828x1792' => $setting->pwa_splash_828x1792 ? '/storage/'.$setting->pwa_splash_828x1792 : "/images/icons/splash-828x1792.png",
                '1125x2436' => $setting->pwa_splash_1125x2436 ? '/storage/'.$setting->pwa_splash_1125x2436 : "/images/icons/splash-1125x2436.png",
                '1242x2208' => $setting->pwa_splash_1242x2208 ? '/storage/'.$setting->pwa_splash_1242x2208 : "/images/icons/splash-1242x2208.png",
                '1242x2688' => $setting->pwa_splash_1242x2688 ? '/storage/'.$setting->pwa_splash_1242x2688 : "/images/icons/splash-1242x2688.png",
                '1536x2048' => $setting->pwa_splash_1536x2048 ? '/storage/'.$setting->pwa_splash_1536x2048 : "/images/icons/splash-1536x2048.png",
                '1668x2224' => $setting->pwa_splash_1668x2224 ? '/storage/'.$setting->pwa_splash_1668x2224 : "/images/icons/splash-1668x2224.png",
                '1668x2388' => $setting->pwa_splash_1668x2388 ? '/storage/'.$setting->pwa_splash_1668x2388 : "/images/icons/splash-1668x2388.png",
                '2048x2732' => $setting->pwa_splash_2048x2732 ? '/storage/'.$setting->pwa_splash_2048x2732 : "/images/icons/splash-2048x2732.png",
            ],
            'icons' => [
                [
                    'src' => $setting->pwa_icons_72x72 ? '/storage/'.$setting->pwa_icons_72x72 : "/images/icons/icon-72x72.png",
                    'type' => 'image/png',
                    'sizes' => "72x72",
                    'purpose' => 'any'
                ],
                [
                    'src' => $setting->pwa_icons_96x96 ? '/storage/'.$setting->pwa_icons_96x96 : "/images/icons/icon-96x96.png",
                    'type' => 'image/png',
                    'sizes' => "96x96",
                    'purpose' => 'any'
                ],
                [
                    'src' => $setting->pwa_icons_128x128 ? '/storage/'.$setting->pwa_icons_128x128 : "/images/icons/icon-128x128.png",
                    'type' => 'image/png',
                    'sizes' => "128x128",
                    'purpose' => 'any'
                ],
                [
                    'src' => $setting->pwa_icons_144x144 ? '/storage/'.$setting->pwa_icons_144x144 : "/images/icons/icon-144x144.png",
                    'type' => 'image/png',
                    'sizes' => "144x144",
                    'purpose' => 'any'
                ],
                [
                    'src' => $setting->pwa_icons_152x152 ? '/storage/'.$setting->pwa_icons_152x152 : "/images/icons/icon-152x152.png",
                    'type' => 'image/png',
                    'sizes' => "152x152",
                    'purpose' => 'any'
                ],
                [
                    'src' => $setting->pwa_icons_192x192 ? '/storage/'.$setting->pwa_icons_192x192 : "/images/icons/icon-192x192.png",
                    'type' => 'image/png',
                    'sizes' => "192x192",
                    'purpose' => 'any'
                ],
                [
                    'src' => $setting->pwa_icons_384x384 ? '/storage/'.$setting->pwa_icons_384x384 : "/images/icons/icon-384x384.png",
                    'type' => 'image/png',
                    'sizes' => "384x384",
                    'purpose' => 'any'
                ],
                [
                    'src' => $setting->pwa_icons_512x512 ? '/storage/'.$setting->pwa_icons_512x512 : "/images/icons/icon-512x512.png",
                    'type' => 'image/png',
                    'sizes' => "512x512",
                    'purpose' => 'any'
                ],
            ]
        ];

        foreach ($basicManifest['icons'] as $key=>$icon){
            $fileInfo = pathinfo(storage_path('app/public/' .$icon['src']));
            $basicManifest['icons'][$key]['type'] = 'image/' . $fileInfo['extension'];
        }


        if ($setting->pwa_shortcuts) {
            foreach ($setting->pwa_shortcuts as $shortcut) {

                if (array_key_exists("icon", $shortcut)) {
                    $fileInfo = pathinfo(storage_path('app/public/' . $shortcut['icon']));
                    $icon = [
                        'src' => $shortcut['icon'],
                        'type' => 'image/' . $fileInfo['extension'],
                        'sizes' => "72x72",
                        'purpose' => "any"
                    ];
                } else {
                    $icon = [];
                }

                $basicManifest['shortcuts'][] = [
                    'name' => trans($shortcut['name']),
                    'description' => trans($shortcut['description']),
                    'url' => $shortcut['url'],
                    'icons' => [
                        $icon
                    ]
                ];
            }
        }

        return $basicManifest;
    }
}
