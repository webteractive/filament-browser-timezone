# AGENTS.md

This file provides guidance to OpenAI Codex CLI when working with code in this repository.

## Common Commands

```bash
# Run tests
composer test                    # Run full test suite (Pest)
vendor/bin/pest                  # Direct Pest invocation
vendor/bin/pest tests/Unit       # Run only unit tests
vendor/bin/pest tests/Feature    # Run only feature tests
vendor/bin/pest --filter="test name"  # Run a single test by name

# Static analysis
composer analyse                 # PHPStan level 5

# Code formatting
composer format                  # Laravel Pint (preset: laravel, imports sorted by length)

# Release (asks for type: patch/minor/major or exact version)
./release.sh patch
```

## Architecture

This is a Laravel package (`webteractive/filament-browser-timezone`) that detects the user's browser timezone via JavaScript and stores it in the Laravel session.

### How It Works

1. **ServiceProvider** (`FilamentBrowserTimezoneServiceProvider`) registers a Filament render hook at `BODY_START` that injects a hidden Livewire component
2. **Livewire component** (`BrowserTimezoneSync`) renders an Alpine.js `x-data` div that calls `Intl.DateTimeFormat().resolvedOptions().timeZone` on init, then sends it to the server via `$wire.setBrowserTimezone(tz)`
3. **Static helper** (`BrowserTimezone`) reads/writes the timezone from/to the session — this is the public API consumers use (`BrowserTimezone::get()`, `::has()`, `::set()`, `::clear()`)
4. **Artisan command** (`filament:timezone:clear`) clears the stored timezone from session

### Key Files

- `src/BrowserTimezone.php` — Static facade-like API for getting/setting timezone in session
- `src/Livewire/BrowserTimezoneSync.php` — Livewire component with inline Blade template (Alpine.js)
- `src/FilamentBrowserTimezoneServiceProvider.php` — Package registration via spatie/laravel-package-tools
- `config/filament-browser-timezone.php` — Config: `session_key`, `fallback_timezone`, `debug`

### Testing

Tests use Orchestra Testbench with `TestCase` in `tests/TestCase.php`. Pest is configured to use this base class for all tests via `tests/Pest.php`. The test environment uses array session driver and sets a random app key for Laravel 12 compatibility.

### Version Compatibility

Supports Filament v3/v4/v5, Livewire v3/v4, Laravel 10/11/12/13, PHP 8.2+.

### Pint Configuration

Laravel preset with imports sorted by length (`pint.json`).
