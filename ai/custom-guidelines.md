# Filament Browser Timezone - AI Custom Guidelines

## Package Overview

The `webteractive/filament-browser-timezone` package automatically detects the user's browser timezone and makes it available to Filament applications (v3, v4, and v5) via session storage. This enables timezone-aware data display and input across Filament Tables, Forms, Widgets, and Infolists.

### Key Features
- **Automatic Detection**: Detects browser timezone on page load using JavaScript `Intl.DateTimeFormat` API
- **Session Storage**: Stores timezone in Laravel session for backend access
- **Filament Integration**: Seamlessly integrates via Filament's render hook system
- **Zero Configuration**: Works out of the box with sensible defaults
- **Backward Compatible**: Supports Filament v3, v4, and v5

### How It Works
1. Package registers a Livewire component via Filament's `BODY_START` render hook
2. On page load, JavaScript detects the browser timezone using `Intl.DateTimeFormat().resolvedOptions().timeZone`
3. Timezone is sent to the server via Livewire and stored in Laravel session
4. Backend code accesses timezone using the `BrowserTimezone` helper class

## Installation

```bash
composer require webteractive/filament-browser-timezone
```

The package auto-discovers via Laravel's service provider registration.

## Core API

### BrowserTimezone Helper Class

```php
use Webteractive\FilamentBrowserTimezone\BrowserTimezone;

// Get detected timezone
$timezone = BrowserTimezone::get();

// Get with custom fallback (default is 'UTC')
$timezone = BrowserTimezone::get('America/New_York');

// Check if timezone is available
if (BrowserTimezone::has()) {
    $timezone = BrowserTimezone::get();
}

// Set timezone manually (rarely needed)
BrowserTimezone::set('Asia/Manila');

// Clear timezone from session
BrowserTimezone::clear();
```

## Common Usage Patterns

### Filament Table Columns

Display datetime columns in the user's browser timezone:

```php
use Filament\Tables\Columns\TextColumn;
use Webteractive\FilamentBrowserTimezone\BrowserTimezone;

TextColumn::make('created_at')
    ->dateTime()
    ->timezone(BrowserTimezone::get())
    ->label('Created At')
```

**Important**: Always call `BrowserTimezone::get()` inside the column definition method, not as a class property, to ensure the timezone is fetched when the table renders.

### Filament Form Fields

DateTimePicker fields with timezone awareness:

```php
use Filament\Forms\Components\DateTimePicker;
use Webteractive\FilamentBrowserTimezone\BrowserTimezone;

DateTimePicker::make('scheduled_at')
    ->timezone(BrowserTimezone::get())
    ->label('Schedule For')
    ->native(false) // Use Flatpickr for better timezone support
```

### Filament Widgets

Use in custom widgets for timezone-aware data queries:

```php
use Webteractive\FilamentBrowserTimezone\BrowserTimezone;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class OrderStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $userTimezone = BrowserTimezone::get();

        // Convert dates to user's timezone for display
        $todayInUserTz = now()->setTimezone($userTimezone)->startOfDay();

        return [
            Stat::make('Today\'s Orders', Order::whereDate('created_at', $todayInUserTz)->count()),
        ];
    }
}
```

### Filament Infolists

Display timezone-aware data in infolists:

```php
use Filament\Infolists\Components\TextEntry;
use Webteractive\FilamentBrowserTimezone\BrowserTimezone;

TextEntry::make('last_login_at')
    ->dateTime()
    ->timezone(BrowserTimezone::get())
```

### Resource Actions

Use in resource actions for timezone conversions:

```php
use Filament\Tables\Actions\Action;
use Webteractive\FilamentBrowserTimezone\BrowserTimezone;

Action::make('schedule')
    ->form([
        DateTimePicker::make('scheduled_for')
            ->timezone(BrowserTimezone::get())
            ->required(),
    ])
    ->action(function (array $data, Model $record) {
        $userTimezone = BrowserTimezone::get();
        // Handle scheduling logic with timezone awareness
    })
```

## Configuration

Publish the configuration file (optional):

```bash
php artisan vendor:publish --tag="filament-browser-timezone-config"
```

### Available Configuration Options

```php
// config/filament-browser-timezone.php
return [
    // Session key for storing timezone
    'session_key' => env('BROWSER_TIMEZONE_SESSION_KEY', 'browser_timezone'),

    // Fallback timezone if detection fails
    'fallback_timezone' => env('BROWSER_TIMEZONE_FALLBACK', 'UTC'),

    // Debug mode (logs timezone detection)
    'debug' => env('BROWSER_TIMEZONE_DEBUG', false),
];
```

### Environment Variables

```env
BROWSER_TIMEZONE_SESSION_KEY=browser_timezone
BROWSER_TIMEZONE_FALLBACK=UTC
BROWSER_TIMEZONE_DEBUG=false
```

## Troubleshooting

### Timezone Not Detected

**Issue**: `BrowserTimezone::get()` returns fallback timezone (UTC by default)

**Solutions**:
1. Check if JavaScript is enabled in the browser
2. Verify Livewire is properly installed and configured
3. Check browser console for JavaScript errors
4. Ensure session is working properly (`php artisan config:cache` may help)
5. Try clearing browser cache and refreshing the page

### Wrong Timezone Displayed

**Issue**: Dates display in wrong timezone

**Solutions**:
1. Ensure you're calling `BrowserTimezone::get()` inside methods, not as class properties
2. Verify the timezone is being passed to the component (Table column, Form field, etc.)
3. Check if `timezone()` method is called on the component
4. For DateTimePicker, ensure `native(false)` is set for better timezone support

### Session Lost Between Requests

**Issue**: Timezone detection works initially but is lost on subsequent requests

**Solutions**:
1. Verify session configuration in `config/session.php`
2. Check session driver is properly configured (database, redis, file, etc.)
3. Ensure cookies are enabled in the browser
4. Check if session middleware is applied to Filament routes

### Multiple Panels

**Issue**: Timezone not detected in some panels

**Solution**: The package automatically registers with all Filament panels via the `BODY_START` render hook. If issues occur:
1. Verify each panel has Livewire enabled
2. Check render hooks are not being overridden in panel configuration
3. Ensure service provider is properly registered

## Browser Compatibility

The package uses the modern `Intl.DateTimeFormat` API, supported by:
- Chrome 24+
- Firefox 29+
- Safari 10+
- Edge 12+
- All modern mobile browsers

For unsupported browsers, the configured fallback timezone is used automatically.

## Best Practices

### 1. Always Use Inside Methods
```php
// ✅ CORRECT - Call inside method
TextColumn::make('created_at')
    ->dateTime()
    ->timezone(BrowserTimezone::get())

// ❌ WRONG - Don't use as class property
protected string $timezone = BrowserTimezone::get(); // This evaluates once at class definition time
```

### 2. Provide Meaningful Fallbacks
```php
// Use application's default timezone as fallback
$timezone = BrowserTimezone::get(config('app.timezone'));
```

### 3. Cache When Making Multiple Calls
```php
public function form(Form $form): Form
{
    $timezone = BrowserTimezone::get(); // Cache in variable

    return $form->schema([
        DateTimePicker::make('start_date')->timezone($timezone),
        DateTimePicker::make('end_date')->timezone($timezone),
        DateTimePicker::make('reminder_at')->timezone($timezone),
    ]);
}
```

### 4. Consider User Preferences
```php
// Allow users to override detected timezone
$timezone = auth()->user()->preferred_timezone ?? BrowserTimezone::get();
```

### 5. Handle Timezone Conversion for Storage
```php
// Always store in UTC, display in user timezone
DateTimePicker::make('scheduled_at')
    ->timezone(BrowserTimezone::get()) // Display in user timezone
    ->beforeStateDehydrated(fn ($state) => $state?->setTimezone('UTC')) // Store in UTC
```

## Technical Details

### Service Provider Registration
The package registers via `FilamentBrowserTimezoneServiceProvider` which:
1. Registers the Livewire component: `browser-timezone-sync`
2. Hooks into Filament's `BODY_START` render hook
3. Includes the Livewire component on every Filament page

### Livewire Component
`BrowserTimezoneSync` component:
- Renders a hidden component in the DOM
- Uses Alpine.js to detect timezone on mount
- Sends timezone to server via Livewire `$wire.set()` method
- Stores in session using configured key

### Session Storage
- Stored under key: `browser_timezone` (configurable)
- Persists for the duration of the user's session
- Automatically cleared when session expires
- Can be manually cleared using `BrowserTimezone::clear()`

## Version Compatibility

| Package Version | Filament Version | Livewire Version | Laravel Version | PHP Version |
|----------------|------------------|------------------|-----------------|-------------|
| 1.x            | ^3.0\|\|^4.0\|\|^5.0 | ^3.0\|\|^4.0     | ^10.0\|\|^11.28\|\|^12.0 | ^8.2       |

**Important Notes**:
- Filament v3 and v4 use Livewire v3
- Filament v5 uses Livewire v4 (released January 16, 2025)
- This package supports both Livewire v3 and v4 seamlessly
- Filament v5 was primarily released to support Livewire v4 features
- No functional changes between Filament v4 and v5 beyond Livewire version
- Easy upgrade path with no breaking changes in this package

## Common Mistakes to Avoid

1. **Don't call BrowserTimezone::get() at class level**: This evaluates once when the class is defined, not when the component renders
2. **Don't forget to publish config if you need custom session keys**: Default values work for most cases
3. **Don't assume timezone is always available**: Always provide a fallback
4. **Don't mix timezone-aware and timezone-naive code**: Be consistent across your application
5. **Don't store dates without timezone consideration**: Store in UTC, display in user timezone

## Examples for AI Assistants

When a user asks to "make this datetime timezone-aware" or "use browser timezone", apply these patterns:

### For Table Columns
```php
// Before
TextColumn::make('created_at')->dateTime()

// After
TextColumn::make('created_at')
    ->dateTime()
    ->timezone(\Webteractive\FilamentBrowserTimezone\BrowserTimezone::get())
```

### For Form Fields
```php
// Before
DateTimePicker::make('scheduled_at')

// After
DateTimePicker::make('scheduled_at')
    ->timezone(\Webteractive\FilamentBrowserTimezone\BrowserTimezone::get())
    ->native(false)
```

### For Queries
```php
// Before
$records = Model::whereDate('created_at', today())->get();

// After
$userTimezone = \Webteractive\FilamentBrowserTimezone\BrowserTimezone::get();
$todayInUserTz = now()->setTimezone($userTimezone);
$records = Model::whereDate('created_at', $todayInUserTz)->get();
```

## Further Resources

- [Package Repository](https://github.com/webteractive/filament-browser-timezone)
- [Filament Documentation](https://filamentphp.com/docs)
- [Laravel Timezone Handling](https://laravel.com/docs/helpers#dates-and-time)
- [PHP DateTime and Timezones](https://www.php.net/manual/en/datetime.construct.php)
