<?php

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\File;
use Tests\Models\User;
use TomatoPHP\FilamentPWA\Filament\Pages\PWASettingsPage;
use TomatoPHP\FilamentPWA\Settings\PWASettings;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(User::factory()->create());
});

afterEach(function () {
    File::delete(public_path('serviceworker.js'));
});

function pwaUploadFields(): array
{
    return collect(livewire(PWASettingsPage::class)->instance()->form->getFlatFields(withHidden: true))
        ->filter(fn ($field): bool => $field instanceof FileUpload)
        ->all();
}

test('settings page renders', function () {
    get(PWASettingsPage::getUrl())->assertSuccessful();
});

test('form method returns valid schema', function () {
    $page = new PWASettingsPage;

    $schema = $page->form(Schema::make($page));

    expect($schema)->toBeInstanceOf(Schema::class)
        ->and($schema->getComponents())->not->toBeEmpty();
});

test('settings page is filled with the stored settings', function () {
    livewire(PWASettingsPage::class)
        ->assertSuccessful()
        ->assertSchemaStateSet([
            'pwa_app_name' => 'TomatoPHP',
            'pwa_short_name' => 'Tomato',
            'pwa_display' => 'standalone',
        ]);
});

test('saving the settings stores them and publishes the service worker', function () {
    livewire(PWASettingsPage::class)
        ->fillForm([
            'pwa_app_name' => 'My App',
            'pwa_theme_color' => '#ff0000',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $settings = new PWASettings;

    expect($settings->pwa_app_name)->toBe('My App')
        ->and($settings->pwa_theme_color)->toBe('#ff0000')
        ->and(File::exists(public_path('serviceworker.js')))->toBeTrue()
        ->and(File::get(public_path('serviceworker.js')))
        ->toContain("'/images/icons/icon-512x512.png'")
        ->not->toContain('ICONS');
});

test('uploads are stored on the public disk by default', function () {
    $fields = pwaUploadFields();

    // 8 icons + 10 splash screens; the shortcut icon lives inside the repeater items.
    expect($fields)->toHaveCount(18);

    foreach ($fields as $field) {
        expect($field->getDiskName())->toBe('public')
            ->and($field->getVisibility())->toBe('public');
    }
});

test('uploads use the configured disk', function () {
    config()->set('filament-pwa.upload_disk', 's3');

    foreach (pwaUploadFields() as $field) {
        expect($field->getDiskName())->toBe('s3')
            ->and($field->getVisibility())->toBe('private');
    }
});
