This is a package to implement tracking of browser timezone for the filament table columns and form fields to use.

The idea is to add the code below

<!-- Added in the service provide (in the package service provider) -->
```
FilamentView::registerRenderHook(
    PanelsRenderHook::BODY_START,
    fn (): string => Blade::render('@livewire(\'browser-timezone-sync\')'),
);
```

Then the browser-timezone-sync component:

```
<?php

namespace App\Livewire;

use Livewire\Component;

class BrowserTimezoneSync extends Component
{
    protected $listeners = ['setBrowserTimezone'];

    public function setBrowserTimezone($timezone)
    {
        session(['browser_timezone' => $timezone]);
    }

    public function render()
    {
        return <<<'blade'
            <div 
                x-data="{
                    init() {
                        const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
                        if (!sessionStorage.getItem('timezone_sent')) {
                            $wire.setBrowserTimezone(tz);
                            sessionStorage.setItem('timezone_sent', 'true');
                        }
                    }
                }"
                x-init="init()"
                style="display: none;"
            ></div>
        blade;
    }
}
```