# Development Standards & Workflows

## Technology Stack
- **Primary**: PHP 8.1+, Laravel 10+, Filament 3+
- **Frontend**: Livewire, Alpine.js, Blade templates
- **Testing**: PHPUnit/Pest, Laravel testing utilities

## Development Standards

### Code Quality
- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Implement proper error handling and validation
- Write comprehensive tests for all components
- Use type hints and return types where applicable

### Package Development
- Follow Laravel package development best practices
- Use service providers for integration points
- Implement proper configuration management
- Provide clear documentation and examples
- Ensure backward compatibility where possible

### Filament Integration
- Follow Filament's plugin development guidelines
- Use render hooks for seamless integration
- Implement proper asset management
- Follow Filament's UI/UX patterns

## Architecture Patterns

### Component Structure
- **Livewire Components**: Handle server-side logic and state management
- **Service Providers**: Manage package registration and configuration
- **Blade Templates**: Provide view layer and JavaScript integration
- **Configuration Files**: Allow customization of package behavior

### Session Management
- Use Laravel's session system for timezone storage
- Implement proper session key naming conventions
- Handle session fallbacks gracefully
- Consider session security implications

### JavaScript Integration
- Use Alpine.js for client-side interactions
- Minimize JavaScript bundle size
- Implement proper error handling
- Ensure cross-browser compatibility

## Development Workflow

### Feature Development
1. Create feature specification using `zeri add-spec <name>`
2. Write failing tests first (TDD approach)
3. Implement feature following established patterns
4. Ensure all tests pass
5. Update documentation and examples

### Testing Strategy
- Unit tests for business logic
- Integration tests for Filament integration
- Feature tests for complete workflows
- Browser compatibility testing

### Code Review Checklist
- [ ] Follows established patterns
- [ ] Includes proper error handling
- [ ] Has comprehensive test coverage
- [ ] Documentation is updated
- [ ] Performance considerations addressed

### Release Workflow
The project includes an automated release script (`release.sh`) for version management:

**Release Commands:**
- `./release.sh patch` - Patch version bump (1.0.0 → 1.0.1)
- `./release.sh minor` - Minor version bump (1.0.0 → 1.1.0)
- `./release.sh major` - Major version bump (1.0.0 → 2.0.0)
- `./release.sh 1.2.3` - Specific version number

**Release Process:**
1. Ensure all changes are committed and pushed
2. Run the appropriate release command
3. Script automatically handles version updates, tagging, and GitHub release creation

**AI Assistant Commands for Releases:**
When user says "do a release" or similar:
- Ask for release type (patch/minor/major) or use minor as default
- Run `./release.sh <type>` command
- Handle any git sync issues before release

## Important Decisions

### Timezone Detection
- Use browser's `Intl.DateTimeFormat().resolvedOptions().timeZone`
- Store in session for backend access
- Implement fallback for unsupported browsers

### Integration Method
- Use Filament render hooks for automatic inclusion
- Provide manual integration options for flexibility
- Ensure minimal performance impact

### Session Storage
- Use Laravel session system for reliability
- Implement proper cleanup and expiration
- Consider security implications of stored data