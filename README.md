# Filament Browser Timezone

A Filament package that automatically detects the user's browser timezone and makes it available to Filament resources, forms, and widgets via session storage.

## Features

- 🕐 **Automatic Detection**: Detects browser timezone on page load
- 🔒 **Session Storage**: Stores timezone in Laravel session for backend access
- 🎯 **Filament Integration**: Seamlessly integrates with Filament v3, v4, and v5 via render hooks
- 🚀 **Zero Configuration**: Works out of the box with default settings
- 🛡️ **Error Handling**: Graceful fallbacks for unsupported browsers
- ⚡ **Performance Optimized**: Minimal impact on page load performance
- 🤖 **AI-Friendly**: Includes Laravel AI custom guidelines for better AI-assisted development

## Installation

```bash
composer require webteractive/filament-browser-timezone
```

The package will be automatically discovered by Laravel. If you're using Laravel 11, you may need to manually register the service provider in your `config/app.php`:

```php
'providers' => [
    // ...
    Webteractive\FilamentBrowserTimezone\FilamentBrowserTimezoneServiceProvider::class,
],
```

## Usage

### Automatic Integration

The package automatically integrates with Filament and starts detecting timezone on every page load. No additional configuration required.

### Accessing Browser Timezone

#### In Filament Resources, Forms, and Widgets

```php
use Webteractive\FilamentBrowserTimezone\BrowserTimezone;

// Get the detected timezone
$timezone = BrowserTimezone::get();

// Check if timezone is available
if (BrowserTimezone::has()) {
    $timezone = BrowserTimezone::get();
}

// Get with fallback
$timezone = BrowserTimezone::get('UTC');
```

#### In Filament Tables

```php
use Webteractive\FilamentBrowserTimezone\BrowserTimezone;

class UserResource extends Resource
{
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->timezone(BrowserTimezone::get())
                    ->label('Created At'),
            ]);
    }
}
```

#### In Filament Forms

```php
use Webteractive\FilamentBrowserTimezone\BrowserTimezone;

class UserForm extends Form
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DateTimePicker::make('meeting_time')
                    ->timezone(BrowserTimezone::get())
                    ->label('Meeting Time'),
            ]);
    }
}
```

#### In Filament Widgets

```php
use Webteractive\FilamentBrowserTimezone\BrowserTimezone;

class StatsWidget extends Widget
{
    public function getColumns(): int
    {
        return 2;
    }

    protected function getTableQuery(): Builder
    {
        return User::query()
            ->where('created_at', '>=', now()->setTimezone(BrowserTimezone::get()));
    }
}
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag="filament-browser-timezone-config"
```

### Configuration Options

```php
// config/filament-browser-timezone.php

return [
    // Session key for storing timezone
    'session_key' => env('BROWSER_TIMEZONE_SESSION_KEY', 'browser_timezone'),
    

    
    // Fallback timezone if detection fails
    'fallback_timezone' => env('BROWSER_TIMEZONE_FALLBACK', 'UTC'),
    
    // Debug mode
    'debug' => env('BROWSER_TIMEZONE_DEBUG', false),
];
```

### Environment Variables

```env
BROWSER_TIMEZONE_SESSION_KEY=browser_timezone
BROWSER_TIMEZONE_FALLBACK=UTC
BROWSER_TIMEZONE_DEBUG=false
```

## How It Works

1. **Automatic Integration**: The package automatically integrates with Filament panels using render hooks
2. **Page Load**: When a Filament page loads, the package automatically includes a hidden Livewire component
3. **JavaScript Detection**: The component uses JavaScript to detect the browser's timezone using `Intl.DateTimeFormat().resolvedOptions().timeZone`
4. **Session Storage**: The detected timezone is sent to the server via Livewire and stored in the Laravel session
5. **Filament Integration**: Your Filament resources, forms, and widgets can now access the timezone using the `BrowserTimezone` helper class

## Filament Features

- **Automatic Detection**: Works out of the box with all Filament panels
- **Render Hook Integration**: Uses Filament's render hook system for seamless integration
- **Livewire Component**: Built with Livewire for optimal performance
- **Session Management**: Integrates with Laravel's session system

## Browser Compatibility

The package uses the modern `Intl.DateTimeFormat` API which is supported by:
- Chrome 24+
- Firefox 29+
- Safari 10+
- Edge 12+

For unsupported browsers, the package will use the configured fallback timezone.

## Version Compatibility

| Package Version | Filament Version | Livewire Version | Laravel Version | PHP Version |
|----------------|------------------|------------------|-----------------|-------------|
| 1.x            | ^3.0\|\|^4.0\|\|^5.0 | ^3.0\|\|^4.0     | ^10.0\|\|^11.28\|\|^12.0 | ^8.2       |

**Note**: Filament v3 and v4 use Livewire v3, while Filament v5 uses Livewire v4. This package supports both Livewire versions seamlessly.

## Laravel AI Guidelines

This package includes custom AI guidelines for Laravel 12.x AI features. When using AI assistants with Laravel 12.x projects, the assistant will have access to comprehensive documentation about this package's usage patterns, best practices, and troubleshooting tips.

The AI guidelines are located in `ai/custom-guidelines.md` and provide:
- Complete API reference
- Common usage patterns for Tables, Forms, and Widgets
- Troubleshooting guides
- Best practices and examples
- Common mistakes to avoid

## Testing

```bash
composer test
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests
5. Submit a pull request

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
