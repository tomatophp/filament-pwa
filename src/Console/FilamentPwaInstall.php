<?php

namespace TomatoPHP\FilamentPWA\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use TomatoPHP\ConsoleHelpers\Traits\RunCommand;
use TomatoPHP\FilamentPWA\Settings\PWASettings;

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

        $dbPath = File::files(database_path('migrations'));
        $exists = false;
        foreach ($dbPath as $path){
            if(str($path->getFilename())->contains('_pwa_settings.php')){
                $exists = true;
            }
        }
        //Register migrations
        if (!$exists) {
            $stubPath =  __DIR__ . '/../../database/migrations/pwa_settings.php.stub';
            $databasePath = database_path('migrations/' . date('Y_m_d_His', time()) . '_pwa_settings.php');

            File::copy($stubPath, $databasePath);
        }
        Artisan::call('migrate');
        File::copyDirectory(__DIR__ . '/../../resources/images', public_path('images'));

        $setting = new PWASettings();
        $jsPath = __DIR__ . '/../../resources/js/serviceworker.js';
        $getJsWorkerFile = File::exists($jsPath);
        if($getJsWorkerFile){
            $getJsWorkerFile = File::get($jsPath);
            $icons = [];
            $setting->pwa_icons_72x72 ? $icons[] = '    "'.'/storage/' . $setting->pwa_icons_72x72 : "/images/icons/icon-72x72.png";
            $setting->pwa_icons_96x96 ? $icons[] = '    "'.'/storage/' . $setting->pwa_icons_96x96 : "/images/icons/icon-96x96.png";
            $setting->pwa_icons_128x128 ? $icons[] = '    "'.'/storage/' . $setting->pwa_icons_128x128 : "/images/icons/icon-128x128.png";
            $setting->pwa_icons_144x144 ? $icons[] = '    "'.'/storage/' . $setting->pwa_icons_144x144 : "/images/icons/icon-144x144.png";
            $setting->pwa_icons_152x152 ? $icons[] = '    "'.'/storage/' . $setting->pwa_icons_152x152 : "/images/icons/icon-152x152.png";
            $setting->pwa_icons_192x192 ? $icons[] = '    "'.'/storage/' . $setting->pwa_icons_192x192 : "/images/icons/icon-192x192.png";
            $setting->pwa_icons_384x384 ? $icons[] = '    "'.'/storage/' . $setting->pwa_icons_384x384 : "/images/icons/icon-384x384.png";
            $setting->pwa_icons_512x512 ? $icons[] = '    "'.'/storage/' . $setting->pwa_icons_512x512 : "/images/icons/icon-512x512.png";

            $value = str($getJsWorkerFile)->replace('ICONS', collect($icons)->implode('",'."\n") . '"')->__toString();

            File::put(public_path('serviceworker.js'), $value);
        }

        $this->info('Filament PWA installed successfully.');
    }
}
