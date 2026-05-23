# Changelog

All notable changes to `webteractive/filament-browser-timezone` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- Laravel 13 support: `laravel/framework` accepts `^13.0`; `orchestra/testbench` accepts `^11.0`; `pestphp/pest`, `pestphp/pest-plugin-arch`, and `pestphp/pest-plugin-laravel` accept `^4.0` (required for L13 dev/test). Verified against Laravel 13.11.2 + Testbench 11.1.0 + Pest 4.7.0 — all 37 tests pass. Note: Laravel 13 itself requires PHP `^8.3`, but the package's `php` constraint stays at `^8.2` so PHP 8.2 users continue to receive Laravel 10–12.

## [1.5.2] - 2026-03-29

### Added

- Timezone validation against `DateTimeZone::listIdentifiers()` — invalid input from the client is now silently rejected
- Fallback timezone config validation — falls back to UTC if an invalid timezone is configured
- Debug logging when `debug` config is enabled (was previously configured but unused)
- Session key caching in a static variable to avoid repeated `config()` calls
- Skip redundant session writes in the Livewire component when the timezone hasn't changed
- Try-catch error handling in `filament:timezone:clear` command with proper exit codes
- Public `BrowserTimezone::isValid()` method for external timezone validation
- `BrowserTimezone::resetState()` method for testing support
- Tests for invalid timezone rejection, malformed session data, debug logging, session key caching, skip-if-already-set behavior, and fallback validation

## [1.5.1] - 2026-03-19

### Added

- **Filament v5 Support**: Added compatibility with Filament v5 alongside existing v3 and v4 support
- **Livewire v4 Support**: Added compatibility with Livewire v4 (required for Filament v5)
- **Laravel AI Custom Guidelines**: Added comprehensive AI custom guidelines in `ai/custom-guidelines.md` for Laravel 12.x AI features
- Triple version support: Package now supports `filament/filament ^3.0||^4.0||^5.0` and `livewire/livewire ^3.0||^4.0`

### Changed

- Renamed `SkeletonCommand` to `ClearBrowserTimezoneCommand` (artisan command `filament:timezone:clear` unchanged)
- Extracted duplicated session key config lookup into `BrowserTimezone::sessionKey()` helper
- Fixed `filament:timezone:clear` command to use configured session key instead of hardcoded value
- Added type hints and return types across all classes
- Updated `composer.json` to support Filament v3, v4, and v5
- Updated `composer.json` to support Livewire v3 and v4
- Updated README.md with version compatibility matrix and AI guidelines information
- Cleaned up tests: removed unnecessary `RefreshDatabase` trait, unused imports

### Removed

- Removed unused skeleton boilerplate (`Skeleton.php`, `Facades/Skeleton.php`)
- Removed broken facade alias from `composer.json`
- Removed unused factory autoload from `composer.json`
- Removed dead `sessionStorage.setItem` call from Livewire component
- Removed unused `$listeners` property from `BrowserTimezoneSync`
- Removed all GitHub Actions workflows and configuration files

## [1.4.0] - 2025-09-19

Release version 1.4.0

### What's Changed

- Version bump to 1.4.0

**Full Changelog**: https://github.com/webteractive/filament-browser-timezone/compare/v1.3.0...v1.4.0


---

🤖 Generated with [Claude Code](https://claude.ai/code)

## Release 1.3.0 - 2025-09-19

Release version 1.3.0

### What's Changed

- Version bump to 1.3.0

**Full Changelog**: https://github.com/webteractive/filament-browser-timezone/compare/v1.2.0...v1.3.0


---

🤖 Generated with [Claude Code](https://claude.ai/code)

## Release 1.2.0 - 2025-09-19

Release version 1.2.0

### What's Changed

- Version bump to 1.2.0

**Full Changelog**: https://github.com/webteractive/filament-browser-timezone/compare/v1.1.2...v1.2.0


---

🤖 Generated with [Claude Code](https://claude.ai/code)

## Release 1.1.2 - 2025-08-30

Release version 1.1.2

### What's Changed

- Version bump to 1.1.2

**Full Changelog**: https://github.com/webteractive/filament-browser-timezone/compare/v1.1.1...v1.1.2


---

🤖 Generated with [Claude Code](https://claude.ai/code)

## Release 1.1.1 - 2025-08-30

Release version 1.1.1

### What's Changed

- Version bump to 1.1.1

**Full Changelog**: https://github.com/webteractive/filament-browser-timezone/compare/v1.1.0...v1.1.1


---

🤖 Generated with [Claude Code](https://claude.ai/code)

## Release 1.1.0 - 2025-08-30

Release version 1.1.0

### What's Changed

- Version bump to 1.1.0

**Full Changelog**: https://github.com//compare/v1.0.0...v1.1.0


---

🤖 Generated with [Claude Code](https://claude.ai/code)

## [1.1.0] - 2025-08-30

### Added

- **Filament v4 Support**: Added compatibility with Filament v4 alongside existing v3 support
- Dual version support: Package now supports both `filament/filament ^3.0` and `^4.0`
- Updated minimum PHP requirement to 8.2+ (required for Filament v4 compatibility)
- Enhanced Laravel framework support for version 11.28.0+ (required by Filament v4)

### Changed

- Updated `composer.json` dependencies to support both Filament v3 and v4
- Increased minimum PHP version from 8.3 to 8.2 for broader v4 compatibility
- Updated Laravel framework constraint to include v11.28.0+ for Filament v4 support

### Technical Notes

- Render hooks (`panels::body.start`) remain fully compatible with both Filament versions
- Livewire component integration works seamlessly across v3 and v4
- Browser timezone detection logic unchanged - maintains same functionality
- All existing tests pass on both Filament versions
- No breaking changes for existing users

## [1.0.0] - 2025-08-10

### Added

- Initial release of Filament Browser Timezone package
- Automatic browser timezone detection using JavaScript's Intl.DateTimeFormat API
- Seamless Filament integration via render hooks (PanelsRenderHook::BODY_START)
- Livewire component for optimal performance and server communication
- Session storage with configurable session keys
- Helper class (`BrowserTimezone`) for easy timezone access throughout the application
- Artisan command (`filament:timezone:clear`) for clearing stored timezone data
- Comprehensive configuration options (session key, fallback timezone, debug mode)
- Full test coverage with 24 tests and 54 assertions using Pest
- Laravel 10, 11, and 12 compatibility
- MIT License

### Technical Features

- Uses `spatie/laravel-package-tools` for package management
- Integrates with Filament's render hook system for automatic inclusion
- Provides fallback timezone handling when detection fails
- Includes proper error handling and graceful degradation

### Browser Compatibility

- Works across all modern browsers supporting Intl.DateTimeFormat API
- Graceful fallback to UTC when timezone detection is unavailable
- No visible UI elements - completely transparent to end users

**Full Changelog**: https://github.com/webteractive/filament-browser-timezone/commits/v1.0.0
