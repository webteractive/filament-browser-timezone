<?php

namespace Webteractive\FilamentBrowserTimezone;

use Livewire\Livewire;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Filament\Support\Facades\FilamentView;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Webteractive\FilamentBrowserTimezone\Commands\SkeletonCommand;
use Webteractive\FilamentBrowserTimezone\Livewire\BrowserTimezoneSync;

class FilamentBrowserTimezoneServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-browser-timezone')
            ->hasConfigFile()
            ->hasViews()
            ->hasCommand(SkeletonCommand::class);
    }

    public function packageBooted(): void
    {
        // Register the Livewire component
        Livewire::component('browser-timezone-sync', BrowserTimezoneSync::class);

        // Register the render hook to include the timezone sync component
        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_START,
            fn (): string => Blade::render('@livewire(\'browser-timezone-sync\')')
        );
    }
}
