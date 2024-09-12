![Screenshot](https://raw.githubusercontent.com//tomatophp/filament-pwa/master/arts/3x1io-tomato-pwa.jpg)

# Filament PWA

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-pwa/version.svg)](https://packagist.org/packages/tomatophp/filament-pwa)
[![License](https://poser.pugx.org/tomatophp/filament-pwa/license.svg)](https://packagist.org/packages/tomatophp/filament-pwa)
[![Downloads](https://poser.pugx.org/tomatophp/filament-pwa/d/total.svg)](https://packagist.org/packages/tomatophp/filament-pwa)

get a PWA feature on your FilamentPHP app with settings from panel

## Installation

```bash
composer require tomatophp/filament-pwa
```

now you need to publish and migrate settings table

```bash
php artisan vendor:publish --provider="Spatie\LaravelSettings\LaravelSettingsServiceProvider" --tag="migrations"
php artisan filament-settings-hub:install 
```

after install your package please run this command

```bash
php artisan filament-pwa:install
```

finally reigster the plugin on `/app/Providers/Filament/AdminPanelProvider.php`

```php
->plugin(\TomatoPHP\FilamentPWA\FilamentPWAPlugin::make())
```

## Screenshots

![Install](https://raw.githubusercontent.com/tomatophp/filament-pwa/master/arts/install.png)
![App](https://raw.githubusercontent.com/tomatophp/filament-pwa/master/arts/app.png)
![Setting Hub](https://raw.githubusercontent.com/tomatophp/filament-pwa/master/arts/setting-hub.png)
![Setting Page](https://raw.githubusercontent.com/tomatophp/filament-pwa/master/arts/setting-page.png)


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

