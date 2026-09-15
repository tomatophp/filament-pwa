<?php

namespace Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Schemas\SchemasServiceProvider;
use Filament\SpatieLaravelSettingsPluginServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use Spatie\LaravelSettings\LaravelSettingsServiceProvider;
use Spatie\LaravelSettings\SettingsRepositories\DatabaseSettingsRepository;
use Tests\Models\User;
use TomatoPHP\FilamentPWA\FilamentPwaServiceProvider;
use TomatoPHP\FilamentSettingsHub\FilamentSettingsHubServiceProvider;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seedPWASettings();
    }

    protected function getPackageProviders($app): array
    {
        return [
            ActionsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            NotificationsServiceProvider::class,
            SchemasServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            LivewireServiceProvider::class,
            LaravelSettingsServiceProvider::class,
            SpatieLaravelSettingsPluginServiceProvider::class,
            FilamentSettingsHubServiceProvider::class,
            FilamentPwaServiceProvider::class,
            AdminPanelProvider::class,
        ];
    }

    protected function defineDatabaseMigrations(): void
    {
        // users table; the settings table comes from filament-settings-hub.
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $app['config']->set('app.key', 'base64:yk+bUVuZa1p86Dqjk9OjVK2R1pm6XHxC6xEKFq8utH0=');
        $app['config']->set('filesystems.default', 'local');
        $app['config']->set('auth.providers.users.model', User::class);

        $app['config']->set('settings.default_repository', 'database');
        $app['config']->set('settings.repositories', [
            'database' => [
                'type' => DatabaseSettingsRepository::class,
                'connection' => null,
                'table' => 'settings',
            ],
        ]);
    }

    /**
     * Same defaults as database/migrations/pwa_settings.php.stub, which the install command publishes.
     */
    protected function seedPWASettings(): void
    {
        $settings = [
            'pwa_app_name' => 'TomatoPHP',
            'pwa_short_name' => 'Tomato',
            'pwa_start_url' => '/',
            'pwa_background_color' => '#ffffff',
            'pwa_theme_color' => '#000000',
            'pwa_display' => 'standalone',
            'pwa_orientation' => 'any',
            'pwa_status_bar' => '#000000',
            'pwa_icons_72x72' => '',
            'pwa_icons_96x96' => '',
            'pwa_icons_128x128' => '',
            'pwa_icons_144x144' => '',
            'pwa_icons_152x152' => '',
            'pwa_icons_192x192' => '',
            'pwa_icons_384x384' => '',
            'pwa_icons_512x512' => '',
            'pwa_splash_640x1136' => '',
            'pwa_splash_750x1334' => '',
            'pwa_splash_828x1792' => '',
            'pwa_splash_1125x2436' => '',
            'pwa_splash_1242x2208' => '',
            'pwa_splash_1242x2688' => '',
            'pwa_splash_1536x2048' => '',
            'pwa_splash_1668x2224' => '',
            'pwa_splash_1668x2388' => '',
            'pwa_splash_2048x2732' => '',
            'pwa_shortcuts' => [],
        ];

        foreach ($settings as $name => $value) {
            DB::table('settings')->insert([
                'group' => 'pwa',
                'name' => $name,
                'locked' => false,
                'payload' => json_encode($value),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
