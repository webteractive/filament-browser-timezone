<?php

namespace Webteractive\FilamentBrowserTimezone\Commands;

use Throwable;
use Illuminate\Console\Command;
use Webteractive\FilamentBrowserTimezone\BrowserTimezone;

class ClearBrowserTimezoneCommand extends Command
{
    public $signature = 'filament:timezone:clear';

    public $description = 'Clear browser timezone from session';

    public function handle(): int
    {
        try {
            BrowserTimezone::clear();
        } catch (Throwable $e) {
            $this->error("Failed to clear browser timezone: {$e->getMessage()}");

            return self::FAILURE;
        }

        $this->info('Browser timezone cleared from session.');

        return self::SUCCESS;
    }
}
