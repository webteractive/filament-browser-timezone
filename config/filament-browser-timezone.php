<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Browser Timezone Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for the browser timezone
    | detection functionality.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Session Key
    |--------------------------------------------------------------------------
    |
    | The session key used to store the detected browser timezone.
    |
    */
    'session_key' => env('BROWSER_TIMEZONE_SESSION_KEY', 'browser_timezone'),

    /*
    |--------------------------------------------------------------------------
    | Fallback Timezone
    |--------------------------------------------------------------------------
    |
    | The timezone to use if browser detection fails.
    |
    */
    'fallback_timezone' => env('BROWSER_TIMEZONE_FALLBACK', 'UTC'),

    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    |
    | Enable debug logging for timezone detection.
    |
    */
    'debug' => env('BROWSER_TIMEZONE_DEBUG', false),
];
