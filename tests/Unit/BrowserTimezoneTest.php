<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Webteractive\FilamentBrowserTimezone\BrowserTimezone;

uses(RefreshDatabase::class);

test('it can get browser timezone from session', function () {
    $timezone = 'Europe/London';
    session(['browser_timezone' => $timezone]);

    expect(BrowserTimezone::get())->toBe($timezone);
});

test('it returns fallback timezone when session is empty', function () {
    $fallback = 'Asia/Tokyo';

    expect(BrowserTimezone::get($fallback))->toBe($fallback);
});

test('it can check if timezone exists', function () {
    expect(BrowserTimezone::has())->toBeFalse();

    session(['browser_timezone' => 'America/Chicago']);

    expect(BrowserTimezone::has())->toBeTrue();
});

test('it can set timezone in session', function () {
    $timezone = 'Australia/Sydney';

    BrowserTimezone::set($timezone);

    expect(session('browser_timezone'))->toBe($timezone);
});

test('it can clear timezone from session', function () {
    session(['browser_timezone' => 'Europe/Paris']);

    expect(BrowserTimezone::has())->toBeTrue();

    BrowserTimezone::clear();

    expect(BrowserTimezone::has())->toBeFalse();
});
