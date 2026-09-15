![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-pwa/master/arts/3x1io-tomato-pwa.jpg)

# Filament PWA

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-pwa/version.svg)](https://packagist.org/packages/tomatophp/filament-pwa)
[![License](https://poser.pugx.org/tomatophp/filament-pwa/license.svg)](https://packagist.org/packages/tomatophp/filament-pwa)
[![Downloads](https://poser.pugx.org/tomatophp/filament-pwa/d/total.svg)](https://packagist.org/packages/tomatophp/filament-pwa)

get a PWA feature on your FilamentPHP app with settings from panel

## Version Compatibility

| Plugin | Filament | Laravel | PHP |
|--------|----------|---------|-----|
| 5.x    | 5.x      | 12.x - 13.x | 8.2+ |
| 4.x    | 4.x      | 11.x - 12.x | 8.2+ |
| 1.x    | 3.x      | 10.x - 11.x | 8.1+ |

## Installation

```bash
composer require tomatophp/filament-pwa
```

The settings are stored with [Filament Settings Hub](https://github.com/tomatophp/filament-settings-hub), which creates the `settings` table. If it is not installed yet, run its installer first:

```bash
php artisan filament-settings-hub:install
```

after install your package please run this command

```bash
php artisan filament-pwa:install
```

finally register the plugin on `/app/Providers/Filament/AdminPanelProvider.php`

```php
->plugin(\TomatoPHP\FilamentPWA\FilamentPWAPlugin::make())
```

## Upload Disk

Icons, splash screens and shortcut icons are stored on the `public` disk. To use another disk (for example `s3`), set it in `.env` or in the published config:

```dotenv
FILAMENT_PWA_UPLOAD_DISK=s3
```

The URLs in the manifest then come from that disk's `url()`.

## Screenshots

![Install](https://raw.githubusercontent.com/tomatophp/filament-pwa/master/arts/install.png)
![App](https://raw.githubusercontent.com/tomatophp/filament-pwa/master/arts/app.png)
![Settings](https://raw.githubusercontent.com/tomatophp/filament-pwa/master/arts/pwa-settings-light.png)
![Settings Dark](https://raw.githubusercontent.com/tomatophp/filament-pwa/master/arts/pwa-settings-dark.png)


## Use Directive

you can use directive to allow PWA on none-FilamentPHP pages, just add this directive to your blade file on top of `</head>`

```html
@filamentPWA
```

## Publish Assets

you can publish config file by use this command

```bash
php artisan vendor:publish --tag="filament-pwa-config"
```

you can publish views file by use this command

```bash
php artisan vendor:publish --tag="filament-pwa-views"
```

you can publish languages file by use this command

```bash
php artisan vendor:publish --tag="filament-pwa-lang"
```

## Other Filament Packages

Checkout our [Awesome TomatoPHP](https://github.com/tomatophp/awesome)

