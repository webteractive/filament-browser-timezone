<?php

namespace Webteractive\FilamentBrowserTimezone\Livewire;

use Livewire\Component;
use Webteractive\FilamentBrowserTimezone\BrowserTimezone;

class BrowserTimezoneSync extends Component
{
    protected $listeners = ['setBrowserTimezone'];

    public function setBrowserTimezone($timezone)
    {
        BrowserTimezone::set($timezone);
    }

    public function render()
    {
        return <<<'blade'
            <div
                x-data="{
                    init() {
                        try {
                            const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
                            if (tz) {
                                $wire.setBrowserTimezone(tz);
                                sessionStorage.setItem('timezone_sent', 'true');
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
