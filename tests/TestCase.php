<?php

namespace Webteractive\FilamentBrowserTimezone\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Database\Eloquent\Factories\Factory;
use Webteractive\FilamentBrowserTimezone\FilamentBrowserTimezoneServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Webteractive\\FilamentBrowserTimezone\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            FilamentBrowserTimezoneServiceProvider::class,
            \Livewire\LivewireServiceProvider::class,
            \Filament\FilamentServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        // Set encryption key for Laravel 12 compatibility
        config()->set('app.key', 'base64:'.base64_encode(random_bytes(32)));

        // Configure Livewire for testing
        config()->set('livewire.inject_assets', false);
        config()->set('livewire.inject_morph_markers', false);

        // Configure Filament for testing
        config()->set('filament.layout.sidebar.is_collapsible_on_desktop', false);
        config()->set('filament.layout.sidebar.groups.are_collapsible', false);

        // Set up session driver for testing
        config()->set('session.driver', 'array');
    }
}
