<?php

namespace Webteractive\FilamentBrowserTimezone;

use Livewire\Livewire;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Filament\Support\Facades\FilamentView;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Webteractive\FilamentBrowserTimezone\Livewire\BrowserTimezoneSync;
use Webteractive\FilamentBrowserTimezone\Commands\ClearBrowserTimezoneCommand;

class FilamentBrowserTimezoneServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-browser-timezone')
            ->hasConfigFile()
            ->hasViews()
            ->hasCommand(ClearBrowserTimezoneCommand::class);
    }

    public function packageBooted(): void
    {
        Livewire::component('browser-timezone-sync', BrowserTimezoneSync::class);

        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_START,
            fn (): string => Blade::render('@livewire(\'browser-timezone-sync\')')
        );
    }
}
