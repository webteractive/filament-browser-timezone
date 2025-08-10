<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it can clear browser timezone from session', function () {
    // Set a timezone in session
    session(['browser_timezone' => 'America/New_York']);

    expect(session('browser_timezone'))->toBe('America/New_York');

    // Run the command
    $this->artisan('filament:timezone:clear');

    // Check if timezone was cleared
    expect(session('browser_timezone'))->toBeNull();
});

test('it shows success message when clearing timezone', function () {
    session(['browser_timezone' => 'Europe/London']);

    $this->artisan('filament:timezone:clear')
        ->expectsOutput('Browser timezone cleared from session.')
        ->assertExitCode(0);
});

test('it handles case when no timezone exists in session', function () {
    // Ensure no timezone in session
    session()->forget('browser_timezone');

    $this->artisan('filament:timezone:clear')
        ->expectsOutput('Browser timezone cleared from session.')
        ->assertExitCode(0);
});
