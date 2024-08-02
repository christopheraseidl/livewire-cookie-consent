<?php

namespace christopheraseidl\CookieConsent;

use christopheraseidl\CookieConsent\Commands\BaseCommand;
use christopheraseidl\CookieConsent\Commands\InstallCommand;
use christopheraseidl\CookieConsent\Commands\UninstallCommand;
use christopheraseidl\CookieConsent\Config\AssetConfig;
use christopheraseidl\CookieConsent\Config\CommandConfig;
use christopheraseidl\CookieConsent\Interfaces\AssetConfigInterface;
use christopheraseidl\CookieConsent\Interfaces\CommandConfigInterface;
use christopheraseidl\CookieConsent\Livewire\CookieConsentChanger;
use christopheraseidl\CookieConsent\Livewire\CookieConsentModal;
use christopheraseidl\CookieConsent\View\Components\CookiePolicy;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class CookieConsentServiceProvider extends ServiceProvider
{
    protected AssetConfigInterface $assets;

    /**
     * Bootstrap package services.
     */
    public function boot(): void
    {
        $this->setAssets();
        $this->bootConfigs();
        $this->bootCss();
        $this->bootImages();
        $this->bootTranslations();
        $this->bootViews();
        $this->bootComponents();
        $this->bootAbout();
        $this->bootCommands();
    }

    /**
     * Register any additional services later.
     */
    public function register()
    {
        $this->registerService();
        $this->registerAssetConfig();
        $this->registerCommandConfig();
        $this->registerConfigFiles();
    }

    protected function setAssets(): void
    {
        $this->assets = $this->app->make(AssetConfigInterface::class);
    }

    protected function bootConfigs(): void
    {
        $this->publishes([
            __DIR__ . '/../config/cookie-consent.php' => $this->assets->defaultConfigPath
        ], 'cookie-consent-config');

        $this->mergeConfigFrom(
            __DIR__ . '/../config/cookie-consent.php', 'cookie-consent'
        );

        $this->publishes([
            __DIR__ . '/../config/cookie-consent-files.php' => $this->assets->filesConfigPath
        ], 'cookie-consent-config-files');

        $this->mergeConfigFrom(
            __DIR__ . '/../config/cookie-consent-files.php', 'cookie-consent-files'
        );
    }
    
    protected function bootCss(): void
    {
        $this->publishes([
            __DIR__ . '/../resources/css' => $this->assets->cssPath
        ], 'cookie-consent-css');
    }

    protected function bootImages(): void
    {
        $this->publishes([
            __DIR__ . '/../resources/images' => $this->assets->imagesPath
        ], 'cookie-consent-images');
    }
    
    protected function bootTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'cookie-consent');

        $this->publishes([
            __DIR__ . '/../resources/lang' => $this->assets->translationsPath
        ], 'cookie-consent-translations');
    }

    protected function bootViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cookie-consent');

        $this->publishes([
            __DIR__ . '/../resources/views' => $this->assets->viewsPath
        ], 'cookie-consent-views');
    }

    protected function bootComponents(): void
    {
        Livewire::component('cookie-consent', CookieConsentModal::class);

        Livewire::component('cookie-consent-changer', CookieConsentChanger::class);

        Blade::component('cookie-policy', CookiePolicy::class);

        Blade::component('cookie-consent::components.cookie', 'cookie');

        Blade::component('cookie-consent::components.close', 'close');
    }

    protected function bootAbout(): void
    {
        AboutCommand::add('Laravel Cookie Consent', fn () => ['Version' => '1.0.0']);
    }

    protected function bootCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                UninstallCommand::class,
            ]);
        }
    }

    protected function registerService(): void
    {
        $this->app->singleton(CookieConsentService::class, function (Application $app) {
            return new CookieConsentService();
        });
    }

    protected function registerAssetConfig(): void
    {
        $this->app->bind(AssetConfigInterface::class, AssetConfig::class);
    }

    protected function registerCommandConfig(): void
    {
        $this->app->bind(CommandConfigInterface::class, CommandConfig::class);
    }

    protected function registerConfigFiles(): void
    {
        // Register the default configuration file if it hasn't been published.
        if ($this->app['config']->get('cookie-consent') === null) {
            $this->app['config']->set('cookie-consent', require __DIR__ . '/../config/cookie-consent.php');
        }

        // Register the files configuration file if it hasn't been published.
        if ($this->app['config']->get('cookie-consent-files') === null) {
            $this->app['config']->set('cookie-consent-files', require __DIR__ . '/../config/cookie-consent-files.php');
        }
    }
}