<?php

use Illuminate\Support\Facades\Log;
use Webteractive\FilamentBrowserTimezone\BrowserTimezone;

beforeEach(function () {
    BrowserTimezone::resetState();
});

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

test('it rejects invalid timezone strings', function () {
    BrowserTimezone::set('Invalid/Timezone');

    expect(BrowserTimezone::has())->toBeFalse();
    expect(session('browser_timezone'))->toBeNull();
});

test('it rejects empty and null timezone values', function () {
    BrowserTimezone::set('');
    expect(BrowserTimezone::has())->toBeFalse();

    BrowserTimezone::set(null);
    expect(BrowserTimezone::has())->toBeFalse();
});

test('it validates timezone with isValid', function () {
    expect(BrowserTimezone::isValid('Asia/Manila'))->toBeTrue();
    expect(BrowserTimezone::isValid('America/New_York'))->toBeTrue();
    expect(BrowserTimezone::isValid('UTC'))->toBeTrue();
    expect(BrowserTimezone::isValid('Not/A/Timezone'))->toBeFalse();
    expect(BrowserTimezone::isValid('garbage'))->toBeFalse();
    expect(BrowserTimezone::isValid(''))->toBeFalse();
});

test('it returns UTC when session has invalid timezone data', function () {
    session(['browser_timezone' => 'Not/Valid/Zone']);

    expect(BrowserTimezone::get())->toBe('UTC');
});

test('it handles non-string session data gracefully', function () {
    session(['browser_timezone' => ['array', 'data']]);

    expect(BrowserTimezone::get())->toBe('UTC');

    session(['browser_timezone' => 12345]);

    expect(BrowserTimezone::get())->toBe('UTC');
});

test('it validates fallback_timezone config and falls back to UTC if invalid', function () {
    config(['filament-browser-timezone.fallback_timezone' => 'Invalid/Zone']);

    expect(BrowserTimezone::get())->toBe('UTC');
});

test('it uses valid custom fallback_timezone from config', function () {
    config(['filament-browser-timezone.fallback_timezone' => 'Asia/Manila']);

    expect(BrowserTimezone::get())->toBe('Asia/Manila');
});

test('it caches session key and resets on resetState', function () {
    BrowserTimezone::set('America/Chicago');
    expect(session('browser_timezone'))->toBe('America/Chicago');

    BrowserTimezone::resetState();
    config(['filament-browser-timezone.session_key' => 'custom_tz_key']);

    BrowserTimezone::set('Europe/London');
    expect(session('custom_tz_key'))->toBe('Europe/London');
});

test('it logs debug messages when debug mode is enabled', function () {
    config(['filament-browser-timezone.debug' => true]);

    Log::shouldReceive('debug')
        ->once()
        ->withArgs(fn ($message) => str_contains($message, '[BrowserTimezone]'));

    BrowserTimezone::get();
});

test('it does not log when debug mode is disabled', function () {
    config(['filament-browser-timezone.debug' => false]);

    Log::shouldReceive('debug')->never();

    BrowserTimezone::get();
});
