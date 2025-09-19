<?php

namespace Webteractive\FilamentBrowserTimezone;

use Illuminate\Support\Facades\Session;

class BrowserTimezone
{
    /**
     * Get the detected browser timezone from session.
     *
     * @param  string|null  $fallback
     */
    public static function get($fallback = null): string
    {
        $timezone = Session::get(config('filament-browser-timezone.session_key', 'browser_timezone'));

        if ($timezone && is_string($timezone)) {
            return $timezone;
        }

        return $fallback ?? config('filament-browser-timezone.fallback_timezone', 'UTC');
    }

    /**
     * Check if browser timezone is available.
     */
    public static function has(): bool
    {
        return Session::has(config('filament-browser-timezone.session_key', 'browser_timezone'));
    }

    /**
     * Set the browser timezone in session.
     */
    public static function set(?string $timezone): void
    {
        if (! empty($timezone)) {
            Session::put(config('filament-browser-timezone.session_key', 'browser_timezone'), $timezone);
        }
    }

    /**
     * Clear the browser timezone from session.
     */
    public static function clear(): void
    {
        Session::forget(config('filament-browser-timezone.session_key', 'browser_timezone'));
    }
}
