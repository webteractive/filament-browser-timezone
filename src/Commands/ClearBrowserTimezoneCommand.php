<?php

namespace Webteractive\FilamentBrowserTimezone\Commands;

use Illuminate\Console\Command;
use Webteractive\FilamentBrowserTimezone\BrowserTimezone;

class ClearBrowserTimezoneCommand extends Command
{
    public $signature = 'filament:timezone:clear';

    public $description = 'Clear browser timezone from session';

    public function handle(): int
    {
        BrowserTimezone::clear();

        $this->info('Browser timezone cleared from session.');

        return self::SUCCESS;
    }
}
