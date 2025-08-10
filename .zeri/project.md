# Filament Browser Timezone Package

## Project Overview
A Laravel package that provides browser timezone detection for Filament applications. The package automatically detects the user's browser timezone and makes it available to Filament Tables, Forms, and Infolists via session storage.

## Core Purpose
- Automatically detect user's browser timezone on page load
- Store timezone information in session for backend use
- Integrate seamlessly with Filament's table columns, form fields, and infolists
- Provide timezone-aware data handling capabilities

## Technical Architecture

### Package Structure
- **Service Provider**: Registers render hooks with Filament
- **Livewire Component**: Handles browser timezone detection and session storage
- **Blade Templates**: Provides the necessary view components
- **Configuration**: Allows customization of timezone handling

### Key Components
1. **BrowserTimezoneSync Component**: Livewire component that detects and stores timezone
2. **Service Provider Integration**: Hooks into Filament's render system
3. **Session Management**: Stores timezone data for backend access
4. **Alpine.js Integration**: Uses Alpine.js for client-side timezone detection

### Integration Points
- Filament Panels (via render hooks)
- Livewire components
- Session storage
- Browser JavaScript APIs (Intl.DateTimeFormat)

## Target Use Cases
- Filament table columns that need timezone-aware data display
- Form fields requiring timezone context
- Infolists with timezone-sensitive information
- Any Filament component needing user's local timezone

## Success Criteria
- Seamless integration with existing Filament applications
- Automatic timezone detection without user intervention
- Reliable session storage of timezone data
- Performance-optimized implementation
- Clean, maintainable code structure

