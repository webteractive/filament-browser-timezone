# Changelog

All notable changes to `webteractive/filament-browser-timezone` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
- Implements sessionStorage check to prevent duplicate timezone detection
- Provides fallback timezone handling when detection fails
- Includes proper error handling and graceful degradation

### Browser Compatibility

- Works across all modern browsers supporting Intl.DateTimeFormat API
- Graceful fallback to UTC when timezone detection is unavailable
- No visible UI elements - completely transparent to end users

**Full Changelog**: https://github.com/webteractive/filament-browser-timezone/commits/v1.0.0
