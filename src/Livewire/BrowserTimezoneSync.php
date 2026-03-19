<?php

namespace Webteractive\FilamentBrowserTimezone\Livewire;

use Livewire\Component;
use Webteractive\FilamentBrowserTimezone\BrowserTimezone;

class BrowserTimezoneSync extends Component
{
    public function setBrowserTimezone(?string $timezone): void
    {
        BrowserTimezone::set($timezone);
    }

    public function render(): string
    {
        return <<<'blade'
            <div
                x-data="{
                    init() {
                        try {
                            const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
                            if (tz) {
                                $wire.setBrowserTimezone(tz);
                            }
                        } catch (error) {
                            console.warn('Timezone detection failed:', error);
                        }
                    }
                }"
                x-init="init()"
                style="display: none;"
            ></div>
        blade;
    }
}
