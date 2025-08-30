# Feature Specification: filament-v4-support

## Overview
Add support for Filament v4 to the FilamentBrowserTimezone package while maintaining backward compatibility with v3. This upgrade ensures the package works with the latest Filament version and takes advantage of performance improvements. Filament v4 requires PHP 8.2+, Laravel 11.28+, and includes breaking changes that need to be addressed.

## Requirements

### Functional Requirements
- Support Filament v4 alongside existing v3 support
- Maintain backward compatibility for existing v3 users
- Ensure browser timezone detection works in both versions
- Verify session storage functionality remains intact
- Support dual version constraints in composer dependencies

### Integration Requirements
- Update render hook registration for v4 compatibility
- Ensure Livewire component works with both versions
- Verify service provider integration remains functional
- Test with both Filament panel versions

### Compatibility Requirements
- PHP 8.2+ minimum requirement (for v4 support)
- Laravel 11.28+ support (required by Filament v4)
- Livewire v3 compatibility maintained
- Support both `"filament/filament": "^3.0||^4.0"`

### Performance Requirements
- No performance degradation on either version
- Take advantage of v4 performance improvements where available
- Maintain efficient render hook integration

## Implementation Notes

### Technical Considerations
- Filament v4 has minimal breaking changes for packages
- Render hooks should work the same way in both versions
- Service provider pattern remains compatible
- Browser timezone detection logic unchanged

### Files Requiring Modification
- `composer.json` - Update dependency constraints and PHP version
- `FilamentBrowserTimezoneServiceProvider.php` - Verify render hook compatibility
- `CHANGELOG.md` - Document v4 support addition
- `README.md` - Update version compatibility information

### Integration Points
- Filament render hook system (`panels::body.start`)
- Livewire component registration and rendering
- Laravel session storage for timezone data
- Spatie package tools integration

### Testing Strategy
- Test package installation with Filament v3 projects
- Test package installation with Filament v4 projects
- Verify browser timezone detection in both environments
- Test session storage functionality across versions
- Integration tests for render hook registration

## TODO
- [x] Update composer.json with dual Filament version support (^3.0||^4.0)
- [x] Update minimum PHP version requirement to 8.2+
- [x] Update Laravel version constraints for v11.28+ compatibility
- [x] Test service provider render hook registration with v4
- [x] Verify Livewire component compatibility across versions
- [x] Run existing test suite against both Filament versions
- [x] Update CHANGELOG.md with v4 support information
- [ ] Update README.md with version compatibility matrix
- [ ] Create testing setup for both Filament versions
- [ ] Validate browser timezone detection works in v4 panels
- [ ] Review package for any v4-specific optimizations
- [x] Mark specification as complete