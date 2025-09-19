<?php

namespace Webteractive\FilamentBrowserTimezone\Livewire;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class BrowserTimezoneSync extends Component
{
    protected $listeners = ['setBrowserTimezone'];

    public function setBrowserTimezone($timezone)
    {
        if (is_string($timezone) && ! empty($timezone)) {
            Session::put(config('filament-browser-timezone.session_key', 'browser_timezone'), $timezone);
        }
    }

    public function render()
    {
        return <<<'blade'
            <div 
                x-data="{
                    init() {
                        try {
                            const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
                            if (tz && !sessionStorage.getItem('timezone_sent')) {
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
