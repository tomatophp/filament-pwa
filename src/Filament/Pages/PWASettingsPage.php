<?php

namespace TomatoPHP\FilamentPWA\Filament\Pages;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\Action;
use Filament\Pages\SettingsPage;
use Filament\Forms\Components\Grid;
use Filament\Support\Exceptions\Halt;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Spatie\Sitemap\SitemapGenerator;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\ButtonAction;
use Filament\Forms\Components\FileUpload;
use TomatoPHP\FilamentPWA\Settings\PWASettings;
use TomatoPHP\FilamentSettingsHub\Settings\SitesSettings;
use function Filament\Support\is_app_url;


class PWASettingsPage extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = PWASettings::class;


    protected static ?string $slug = "pwa-settings-page";

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getTitle(): string
    {
        return trans('filament-pwa::messages.settings.title');
    }

    protected function getActions(): array
    {
        return [
            Action::make('back')->action(fn()=> redirect()
                ->route('filament.'.filament()->getCurrentPanel()->getId().'.pages.settings-hub'))
                ->color('danger')
                ->label(trans('filament-settings-hub::messages.back')),
        ];
    }


    protected function getFormSchema(): array
    {
        return [
            Grid::make(['default' => 2])->schema([
                Section::make(trans('filament-pwa::messages.sections.general'))
                    ->collapsible()
                    ->schema([
                        TextInput::make('pwa_app_name')
                            ->label(trans('filament-pwa::messages.form.pwa_app_name'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_app_name")' : null),
                        TextInput::make('pwa_short_name')
                            ->label(trans('filament-pwa::messages.form.pwa_short_name'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_short_name")' : null),
                        TextInput::make('pwa_start_url')
                            ->label(trans('filament-pwa::messages.form.pwa_start_url'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_start_url")' : null),
                    ]),
                Section::make(trans('filament-pwa::messages.sections.style'))
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        ColorPicker::make('pwa_background_color')
                            ->default('#ffffff')
                            ->label(trans('filament-pwa::messages.form.pwa_background_color'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_background_color")' : null),
                        ColorPicker::make('pwa_status_bar')
                            ->default('#000000')
                            ->label(trans('filament-pwa::messages.form.pwa_status_bar'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_status_bar")' : null),
                        ColorPicker::make('pwa_theme_color')
                            ->default('#000000')
                            ->label(trans('filament-pwa::messages.form.pwa_theme_color'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_theme_color")' : null),
                        TextInput::make('pwa_display')
                            ->label(trans('filament-pwa::messages.form.pwa_display'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_display")' : null),
                        TextInput::make('pwa_orientation')
                            ->label(trans('filament-pwa::messages.form.pwa_orientation'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_orientation")' : null),
                    ]),
                Section::make(trans('filament-pwa::messages.sections.icons'))
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        FileUpload::make('pwa_icons_72x72')
                            ->acceptedFileTypes(['image/png'])
                            ->label(trans('filament-pwa::messages.form.pwa_icons_72x72'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_icons_72x72")' : null),
                        FileUpload::make('pwa_icons_96x96')
                            ->acceptedFileTypes(['image/png'])
                            ->label(trans('filament-pwa::messages.form.pwa_icons_96x96'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_icons_96x96")' : null),
                        FileUpload::make('pwa_icons_128x128')
                            ->acceptedFileTypes(['image/png'])
                            ->label(trans('filament-pwa::messages.form.pwa_icons_128x128'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_icons_128x128")' : null),
                        FileUpload::make('pwa_icons_144x144')
                            ->acceptedFileTypes(['image/png'])
                            ->label(trans('filament-pwa::messages.form.pwa_icons_144x144'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_icons_144x144")' : null),
                        FileUpload::make('pwa_icons_152x152')
                            ->acceptedFileTypes(['image/png'])
                            ->label(trans('filament-pwa::messages.form.pwa_icons_152x152'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_icons_152x152")' : null),
                        FileUpload::make('pwa_icons_192x192')
                            ->acceptedFileTypes(['image/png'])
                            ->label(trans('filament-pwa::messages.form.pwa_icons_192x192'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_icons_192x192")' : null),
                        FileUpload::make('pwa_icons_384x384')
                            ->acceptedFileTypes(['image/png'])
                            ->label(trans('filament-pwa::messages.form.pwa_icons_384x384'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_icons_384x384")' : null),
                        FileUpload::make('pwa_icons_512x512')
                            ->acceptedFileTypes(['image/png'])
                            ->label(trans('filament-pwa::messages.form.pwa_icons_512x512'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_icons_512x512")' : null),
                    ]),
                Section::make(trans('filament-pwa::messages.sections.splash'))
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        FileUpload::make('pwa_splash_640x1136')
                            ->acceptedFileTypes(['image/png'])
                            ->label(trans('filament-pwa::messages.form.pwa_splash_640x1136'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_splash_640x1136")' : null),
                        FileUpload::make('pwa_splash_750x1334')
                            ->acceptedFileTypes(['image/png'])
                            ->label(trans('filament-pwa::messages.form.pwa_splash_750x1334'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_splash_750x1334")' : null),
                        FileUpload::make('pwa_splash_828x1792')
                            ->acceptedFileTypes(['image/png'])
                            ->label(trans('filament-pwa::messages.form.pwa_splash_828x1792'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_splash_828x1792")' : null),
                        FileUpload::make('pwa_splash_1125x2436')
                            ->acceptedFileTypes(['image/png'])
                            ->label(trans('filament-pwa::messages.form.pwa_splash_1125x2436'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_splash_1125x2436")' : null),
                        FileUpload::make('pwa_splash_1242x2208')
                            ->acceptedFileTypes(['image/png'])
                            ->label(trans('filament-pwa::messages.form.pwa_splash_1242x2208'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_splash_1242x2208")' : null),
                        FileUpload::make('pwa_splash_1242x2688')
                            ->acceptedFileTypes(['image/png'])
                            ->label(trans('filament-pwa::messages.form.pwa_splash_1242x2688'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_splash_1242x2688")' : null),
                        FileUpload::make('pwa_splash_1536x2048')
                            ->acceptedFileTypes(['image/png'])
                            ->label(trans('filament-pwa::messages.form.pwa_splash_1536x2048'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_splash_1536x2048")' : null),
                        FileUpload::make('pwa_splash_1668x2224')
                            ->acceptedFileTypes(['image/png'])
                            ->label(trans('filament-pwa::messages.form.pwa_splash_1668x2224'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_splash_1668x2224")' : null),
                        FileUpload::make('pwa_splash_1668x2388')
                            ->acceptedFileTypes(['image/png'])
                            ->label(trans('filament-pwa::messages.form.pwa_splash_1668x2388'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_splash_1668x2388")' : null),
                        FileUpload::make('pwa_splash_2048x2732')
                            ->acceptedFileTypes(['image/png'])
                            ->label(trans('filament-pwa::messages.form.pwa_splash_2048x2732'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_splash_2048x2732")' : null),
                    ]),
                Section::make(trans('filament-pwa::messages.sections.shortcuts'))
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Repeater::make('pwa_shortcuts')
                            ->schema([
                                TextInput::make('name')
                                    ->label(trans('filament-pwa::messages.form.pwa_shortcuts_name')),
                                Textarea::make('description')
                                    ->label(trans('filament-pwa::messages.form.pwa_shortcuts_description')),
                                TextInput::make('url')
                                    ->url()
                                    ->label(trans('filament-pwa::messages.form.pwa_shortcuts_url')),
                                FileUpload::make('icon')
                                    ->image()
                                    ->label(trans('filament-pwa::messages.form.pwa_shortcuts_icon')),
                            ])
                            ->label(trans('filament-pwa::messages.form.pwa_shortcuts'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("pwa_shortcuts")' : null),
                    ])
            ])
        ];
    }

    public function afterSave()
    {
        $setting = new PWASettings();
        $jsPath = __DIR__ . '/../../../resources/js/serviceworker.js';
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
    }
}
