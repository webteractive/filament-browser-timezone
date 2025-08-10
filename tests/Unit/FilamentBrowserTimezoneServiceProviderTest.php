<?php

use Webteractive\FilamentBrowserTimezone\FilamentBrowserTimezoneServiceProvider;

test('it registers package name correctly', function () {
    $provider = new FilamentBrowserTimezoneServiceProvider(app());

    expect($provider)->toBeInstanceOf(FilamentBrowserTimezoneServiceProvider::class);
});

test('it has config file', function () {
    $provider = new FilamentBrowserTimezoneServiceProvider(app());

    expect($provider)->toBeInstanceOf(FilamentBrowserTimezoneServiceProvider::class);
});

test('it has views', function () {
    $provider = new FilamentBrowserTimezoneServiceProvider(app());

    expect($provider)->toBeInstanceOf(FilamentBrowserTimezoneServiceProvider::class);
});

test('it has command', function () {
    $provider = new FilamentBrowserTimezoneServiceProvider(app());

    expect($provider)->toBeInstanceOf(FilamentBrowserTimezoneServiceProvider::class);
});

test('it can boot package', function () {
    $provider = new FilamentBrowserTimezoneServiceProvider(app());

    expect($provider->packageBooted())->toBeNull();
});
