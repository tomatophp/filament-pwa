<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;

test('the @filamentPWA directive compiles to php that renders at request time', function () {
    $compiled = Blade::compileString('@filamentPWA');

    expect($compiled)->toContain('<?php')
        ->toContain('ManifestService::generate()')
        ->not->toContain('apple-mobile-web-app-title');
});

test('the @filamentPWA directive renders the current settings', function () {
    DB::table('settings')
        ->where('group', 'pwa')
        ->where('name', 'pwa_short_name')
        ->update(['payload' => json_encode('Tomato Shop')]);

    expect(Blade::render('@filamentPWA', deleteCachedView: true))
        ->toContain('<meta name="apple-mobile-web-app-title" content="Tomato Shop">');
});
