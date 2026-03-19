<?php

namespace Webteractive\FilamentBrowserTimezone;

use Illuminate\Support\Facades\Session;

class BrowserTimezone
{
    /**
     * Get the detected browser timezone from session.
     */
    public static function get(?string $fallback = null): string
    {
        $timezone = Session::get(static::sessionKey());

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
        return Session::has(static::sessionKey());
    }

    /**
     * Set the browser timezone in session.
     */
    public static function set(?string $timezone): void
    {
        if (! empty($timezone)) {
            Session::put(static::sessionKey(), $timezone);
        }
    }

    /**
     * Clear the browser timezone from session.
     */
    public static function clear(): void
    {
        Session::forget(static::sessionKey());
    }

    private static function sessionKey(): string
    {
        return config('filament-browser-timezone.session_key', 'browser_timezone');
    }
}
