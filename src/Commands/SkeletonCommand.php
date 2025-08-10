<?php

namespace Webteractive\FilamentBrowserTimezone\Commands;

use Illuminate\Console\Command;

class SkeletonCommand extends Command
{
    public $signature = 'filament:timezone:clear';

    public $description = 'Clear browser timezone from session';

    public function handle(): int
    {
        session()->forget('browser_timezone');

        $this->info('Browser timezone cleared from session.');

        return self::SUCCESS;
    }
}
