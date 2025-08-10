<?php

test('it loads configuration file correctly', function () {
    $config = config('filament-browser-timezone');

    expect($config)->toBeArray()
        ->and($config)->toHaveKey('session_key')
        ->and($config)->toHaveKey('fallback_timezone')
        ->and($config)->toHaveKey('debug');
});

test('it has correct default values', function () {
    $config = config('filament-browser-timezone');

    expect($config['session_key'])->toBe('browser_timezone')
        ->and($config['fallback_timezone'])->toBe('UTC')
        ->and($config['debug'])->toBeFalse();
});

test('it respects environment variable overrides', function () {
    // Set environment variables
    config(['filament-browser-timezone.session_key' => 'custom_timezone_key']);
    config(['filament-browser-timezone.fallback_timezone' => 'America/New_York']);
    config(['filament-browser-timezone.debug' => true]);

    expect(config('filament-browser-timezone.session_key'))->toBe('custom_timezone_key')
        ->and(config('filament-browser-timezone.fallback_timezone'))->toBe('America/New_York')
        ->and(config('filament-browser-timezone.debug'))->toBeTrue();
});
