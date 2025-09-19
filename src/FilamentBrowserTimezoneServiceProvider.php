<?php

namespace Webteractive\FilamentBrowserTimezone;

use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Webteractive\FilamentBrowserTimezone\Commands\SkeletonCommand;

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
        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_START,
            fn (): string => Blade::render('@livewire(\'browser-timezone-sync\')')
        );
    }
}
