<?php

use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Webteractive\FilamentBrowserTimezone\BrowserTimezone;
use Webteractive\FilamentBrowserTimezone\Livewire\BrowserTimezoneSync;

uses(RefreshDatabase::class);

test('complete workflow from detection to usage', function () {
    // Simulate timezone detection
    $timezone = 'Europe/Berlin';

    // Test Livewire component
    Livewire::test(BrowserTimezoneSync::class)
        ->call('setBrowserTimezone', $timezone);

    // Verify session storage
    expect(session('browser_timezone'))->toBe($timezone);

    // Test helper class methods
    expect(BrowserTimezone::has())->toBeTrue();
    expect(BrowserTimezone::get())->toBe($timezone);

    // Test fallback behavior
    expect(BrowserTimezone::get('UTC'))->toBe($timezone);

    // Test clearing
    BrowserTimezone::clear();
    expect(BrowserTimezone::has())->toBeFalse();
    expect(BrowserTimezone::get())->toBe('UTC'); // Default fallback
});

test('handles invalid timezone gracefully', function () {
    // Test with invalid timezone
    Livewire::test(BrowserTimezoneSync::class)
        ->call('setBrowserTimezone', '');

    expect(session('browser_timezone'))->toBeNull();
    expect(BrowserTimezone::has())->toBeFalse();
    expect(BrowserTimezone::get())->toBe('UTC');
});

test('configuration integration works correctly', function () {
    // Test custom session key
    config(['filament-browser-timezone.session_key' => 'custom_tz']);

    $timezone = 'Asia/Tokyo';
    BrowserTimezone::set($timezone);

    expect(session('custom_tz'))->toBe($timezone);
    expect(BrowserTimezone::get())->toBe($timezone);

    // Reset config
    config(['filament-browser-timezone.session_key' => 'browser_timezone']);
});

test('multiple timezone updates work correctly', function () {
    $timezones = ['America/New_York', 'Europe/London', 'Asia/Tokyo'];

    foreach ($timezones as $timezone) {
        BrowserTimezone::set($timezone);
        expect(session('browser_timezone'))->toBe($timezone);
        expect(BrowserTimezone::get())->toBe($timezone);
    }

    // Final timezone should be the last one set
    expect(BrowserTimezone::get())->toBe('Asia/Tokyo');
});
