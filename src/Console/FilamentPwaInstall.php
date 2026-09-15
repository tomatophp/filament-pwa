<?php

namespace TomatoPHP\FilamentPWA\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use TomatoPHP\ConsoleHelpers\Traits\RunCommand;
use TomatoPHP\FilamentPWA\Services\ManifestService;

class FilamentPwaInstall extends Command
{
    use RunCommand;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'filament-pwa:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install package and publish assets';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Publish Vendor Assets');
        $this->callSilent('optimize:clear');

        $exists = collect(File::files(database_path('migrations')))
            ->contains(fn ($file): bool => str($file->getFilename())->contains('_pwa_settings.php'));

        if (! $exists) {
            File::copy(
                __DIR__.'/../../database/migrations/pwa_settings.php.stub',
                database_path('migrations/'.date('Y_m_d_His').'_pwa_settings.php'),
            );
        }

        Artisan::call('migrate', ['--force' => true]);

        File::copyDirectory(__DIR__.'/../../resources/images', public_path('images'));

        ManifestService::publishServiceWorker();

        $this->info('Filament PWA installed successfully.');

        return self::SUCCESS;
    }
}
