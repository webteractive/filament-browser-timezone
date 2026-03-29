<?php

use Livewire\Livewire;
use Webteractive\FilamentBrowserTimezone\BrowserTimezone;
use Webteractive\FilamentBrowserTimezone\Livewire\BrowserTimezoneSync;

beforeEach(function () {
    BrowserTimezone::resetState();
});

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

test('it rejects invalid timezone via livewire', function () {
    Livewire::test(BrowserTimezoneSync::class)
        ->call('setBrowserTimezone', 'Fake/Timezone');

    expect(session('browser_timezone'))->toBeNull();
});

test('it skips write when timezone is already set to same value', function () {
    BrowserTimezone::set('Asia/Manila');

    expect(BrowserTimezone::get())->toBe('Asia/Manila');

    // Calling again with same value should not error and session stays the same
    Livewire::test(BrowserTimezoneSync::class)
        ->call('setBrowserTimezone', 'Asia/Manila');

    expect(session('browser_timezone'))->toBe('Asia/Manila');
});

test('it updates timezone when a different valid timezone is sent', function () {
    BrowserTimezone::set('Asia/Manila');

    Livewire::test(BrowserTimezoneSync::class)
        ->call('setBrowserTimezone', 'Europe/London');

    expect(session('browser_timezone'))->toBe('Europe/London');
});

test('it renders hidden div', function () {
    $component = Livewire::test(BrowserTimezoneSync::class);

    expect($component->html())
        ->toContain('style="display: none;"')
        ->toContain('x-data')
        ->toContain('x-init="init()"');
});
