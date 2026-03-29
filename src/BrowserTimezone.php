<?php

namespace Webteractive\FilamentBrowserTimezone;

use DateTimeZone;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class BrowserTimezone
{
    private static ?string $cachedSessionKey = null;

    /**
     * Get the detected browser timezone from session.
     */
    public static function get(?string $fallback = null): string
    {
        $timezone = Session::get(static::sessionKey());

        if ($timezone && is_string($timezone) && static::isValid($timezone)) {
            return $timezone;
        }

        $resolved = $fallback ?? static::validatedFallback();

        static::debug('Using fallback timezone', ['timezone' => $resolved]);

        return $resolved;
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
        if (empty($timezone)) {
            return;
        }

        if (! static::isValid($timezone)) {
            static::debug('Rejected invalid timezone', ['timezone' => $timezone]);

            return;
        }

        Session::put(static::sessionKey(), $timezone);
    }

    /**
     * Clear the browser timezone from session.
     */
    public static function clear(): void
    {
        Session::forget(static::sessionKey());
    }

    /**
     * Check if a timezone identifier is valid.
     */
    public static function isValid(string $timezone): bool
    {
        return in_array($timezone, DateTimeZone::listIdentifiers(), true);
    }

    /**
     * Reset cached state (for testing).
     */
    public static function resetState(): void
    {
        static::$cachedSessionKey = null;
    }

    private static function sessionKey(): string
    {
        return static::$cachedSessionKey ??= config('filament-browser-timezone.session_key', 'browser_timezone');
    }

    private static function validatedFallback(): string
    {
        $fallback = config('filament-browser-timezone.fallback_timezone', 'UTC');

        if (is_string($fallback) && static::isValid($fallback)) {
            return $fallback;
        }

        static::debug('Configured fallback_timezone is invalid, using UTC', ['configured' => $fallback]);

        return 'UTC';
    }

    private static function debug(string $message, array $context = []): void
    {
        if (config('filament-browser-timezone.debug', false)) {
            Log::debug("[BrowserTimezone] {$message}", $context);
        }
    }
}
