<?php

use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Webteractive\FilamentBrowserTimezone\Livewire\BrowserTimezoneSync;

uses(RefreshDatabase::class);

test('it can detect and store browser timezone', function () {
    $timezone = 'America/New_York';

    Livewire::test(BrowserTimezoneSync::class)
        ->call('setBrowserTimezone', $timezone);

    expect(session('browser_timezone'))->toBe($timezone);
});

test('it ignores empty timezone values', function () {
    Livewire::test(BrowserTimezoneSync::class)
        ->call('setBrowserTimezone', '')
        ->call('setBrowserTimezone', null);

    expect(session('browser_timezone'))->toBeNull();
});

test('it renders hidden div', function () {
    $component = Livewire::test(BrowserTimezoneSync::class);

    expect($component->html())
        ->toContain('style="display: none;"')
        ->toContain('x-data')
        ->toContain('x-init="init()"');
});
