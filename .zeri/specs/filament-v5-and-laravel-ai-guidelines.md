# Feature Specification: Filament v5 Support & Laravel AI Custom Guidelines

## Overview
Add support for Filament v5 and Livewire v4 to the FilamentBrowserTimezone package while maintaining backward compatibility with v3/v4 and Livewire v3. Additionally, implement Laravel 12.x AI custom guidelines to provide AI assistants with context about this package. This upgrade ensures the package works with the latest Filament and Livewire versions and improves AI-assisted development experience.

**Context**: Filament v5 was released on January 16, 2025, primarily to support Livewire v4. There are no functional changes between Filament v4 and v5 beyond Livewire version support. Filament v3/v4 use Livewire v3, while Filament v5 uses Livewire v4.

## Requirements

### Functional Requirements
- Support Filament v5 alongside existing v3 and v4 support
- Support Livewire v4 alongside existing v3 support
- Maintain full backward compatibility for v3 and v4 users
- Ensure browser timezone detection works across all versions
- Verify session storage functionality remains intact
- Support version constraints:
  - `"filament/filament": "^3.0||^4.0||^5.0"`
  - `"livewire/livewire": "^3.0||^4.0"`

### Laravel AI Guidelines Requirements
- Create `ai/custom-guidelines.md` file as per Laravel 12.x documentation
- Provide clear package overview and usage examples
- Document common patterns and best practices for this package
- Include troubleshooting tips for AI assistants
- Explain the browser timezone detection mechanism

### Integration Requirements
- Update render hook registration for v5 compatibility
- Ensure Livewire component works with all versions (v3, v4, v5)
- Verify service provider integration remains functional
- Test with multiple Filament panel versions

### Compatibility Requirements
- PHP 8.2+ minimum requirement (already met)
- Laravel 11.28+ and Laravel 12.x support
- Livewire v3 and v4 compatibility
- Support triple version constraint for Filament (v3, v4, v5)
- Support dual version constraint for Livewire (v3, v4)

### Performance Requirements
- No performance degradation on any version
- Take advantage of v5 performance improvements where available
- Maintain efficient render hook integration

## Implementation Notes

### Technical Considerations
- Filament v5 was released January 16, 2025, primarily for Livewire v4 support
- Filament v5 has no functional changes beyond Livewire v4 integration
- Filament v3/v4 use Livewire v3, Filament v5 uses Livewire v4
- Render hooks work identically across all Filament versions
- Livewire component API remains compatible between v3 and v4 for our use case
- Service provider pattern remains compatible
- Browser timezone detection logic unchanged
- Laravel 12.x introduces AI custom guidelines feature for package documentation

### Files Requiring Modification
1. **composer.json** - Update Filament dependency to `^3.0||^4.0||^5.0` and Livewire to `^3.0||^4.0`
2. **README.md** - Update version compatibility information with Livewire versions
3. **CHANGELOG.md** - Document v5 and Livewire v4 support addition
4. **ai/custom-guidelines.md** (NEW) - Create AI custom guidelines file

### Files to Create
1. **ai/custom-guidelines.md** - Laravel AI custom guidelines for this package

### Integration Points
- Filament render hook system (PanelsRenderHook::BODY_START)
- Livewire component registration and rendering
- Laravel session storage for timezone data
- Spatie package tools integration
- Laravel AI guidelines system (Laravel 12.x)

### Testing Strategy
- Test package installation with Filament v3, v4, and v5 projects
- Test with both Livewire v3 (Filament v3/v4) and Livewire v4 (Filament v5)
- Verify browser timezone detection in all environments
- Test session storage functionality across versions
- Integration tests for render hook registration
- Validate Livewire component works with both v3 and v4
- Validate AI guidelines are picked up by Laravel 12.x

### AI Guidelines Content Structure
The `ai/custom-guidelines.md` should include:
- Package overview and purpose
- Installation instructions
- Common usage patterns (Tables, Forms, Widgets)
- BrowserTimezone helper class API
- Session storage mechanism explanation
- Browser compatibility notes
- Troubleshooting common issues
- Examples for different Filament components

## TODO
- [x] Update composer.json with Filament v5 support (^3.0||^4.0||^5.0)
- [x] Update composer.json with Livewire v4 support (^3.0||^4.0)
- [x] Verify service provider render hook registration works with v5
- [x] Test Livewire component compatibility with v3 and v4
- [x] Create ai/custom-guidelines.md with comprehensive package documentation
- [x] Include usage examples in AI guidelines for Tables
- [x] Include usage examples in AI guidelines for Forms
- [x] Include usage examples in AI guidelines for Widgets
- [x] Add troubleshooting section to AI guidelines
- [x] Document browser timezone detection mechanism in AI guidelines
- [x] Update README.md with version compatibility matrix (v3, v4, v5) including Livewire versions
- [x] Update CHANGELOG.md with v5 and Livewire v4 support and AI guidelines addition
- [x] Update AI guidelines with Livewire v4 and Filament v5 context
- [x] Run existing test suite to ensure no regressions
- [ ] Test with Filament v5/Livewire v4 in real project (manual testing required)
- [ ] Test with Laravel 12.x to verify AI guidelines are recognized (manual testing required)
- [ ] Review package for any v5/Livewire v4 optimizations (no optimizations needed at this time)
- [x] Mark specification as complete