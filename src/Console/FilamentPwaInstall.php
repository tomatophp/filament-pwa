<?php

namespace TomatoPHP\FilamentPWA\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use TomatoPHP\ConsoleHelpers\Traits\RunCommand;

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

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Publish Vendor Assets');
        $this->callSilent('optimize:clear');
        Artisan::call('vendor:publish --provider="LaravelPWA\Providers\LaravelPWAServiceProvider"');
        $this->info('Filament PWA installed successfully.');
    }
}
