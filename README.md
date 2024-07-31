![Screenshot](https://raw.githubusercontent.com//tomatophp/filament-pwa/master/arts/3x1io-tomato-pwa.jpg)

# Filament PWA

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-pwa/version.svg)](https://packagist.org/packages/tomatophp/filament-pwa)
[![License](https://poser.pugx.org/tomatophp/filament-pwa/license.svg)](https://packagist.org/packages/tomatophp/filament-pwa)
[![Downloads](https://poser.pugx.org/tomatophp/filament-pwa/d/total.svg)](https://packagist.org/packages/tomatophp/filament-pwa)

get a PWA feature on your FilamentPHP app with settings from panel

## Screenshots

![Install](https://raw.githubusercontent.com/tomatophp/filament-pwa/master/arts/install.png)
![App](https://raw.githubusercontent.com/tomatophp/filament-pwa/master/arts/app.png)
![Setting Hub](https://raw.githubusercontent.com/tomatophp/filament-pwa/master/arts/setting-hub.png)
![Setting Page](https://raw.githubusercontent.com/tomatophp/filament-pwa/master/arts/setting-page.png)

## Installation

```bash
composer require tomatophp/filament-pwa
```

now you need to publish and migrate settings table

```bash
php artisan vendor:publish --provider="Spatie\LaravelSettings\LaravelSettingsServiceProvider" --tag="migrations"
```

after install your package please run this command

```bash
php artisan filament-pwa:install
```

finally reigster the plugin on `/app/Providers/Filament/AdminPanelProvider.php`

```php
->plugin(\TomatoPHP\FilamentPWA\FilamentPWAPlugin::make())
```


## Publish Assets

you can publish views file by use this command

```bash
php artisan vendor:publish --tag="filament-pwa-views"
```

you can publish languages file by use this command

```bash
php artisan vendor:publish --tag="filament-pwa-lang"
```

## Support

you can join our discord server to get support [TomatoPHP](https://discord.gg/vKV9U7gD3c)

## Docs

you can check docs of this package on [Docs](https://docs.tomatophp.com/plugins/filament-pwa)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

Please see [SECURITY](SECURITY.md) for more information about security.

## Credits

- [Fady Mondy](https://wa.me/+201207860084)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
