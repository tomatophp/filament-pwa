# Changelog

## v5.0.0

- Support Filament v5 and Laravel 12 / 13 (PHP 8.2+).
- Configurable filesystem disk for icons, splash screens and shortcut icons (`filament-pwa.upload_disk`, `FILAMENT_PWA_UPLOAD_DISK`), thanks to @Deadman69 (#22).
- One service worker implementation shared by the route, the settings page and the install command.
- `@filamentPWA` renders on every request instead of being baked into the compiled view.
- The panel no longer fails when `filament-pwa.allow_routes` is disabled.
- `allowPWASettings(false)` only affects the panel it is called on.
- The settings hub plugin is only added when the panel does not already register it.
- Test suite for the plugin, settings page, manifest, service worker, uploads disk and install command.
