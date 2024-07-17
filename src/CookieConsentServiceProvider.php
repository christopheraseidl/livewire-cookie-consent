<?php

namespace christopheraseidl\CookieConsent;

use christopheraseidl\CookieConsent\Commands\InstallCommand;
use christopheraseidl\CookieConsent\Commands\UninstallCommand;
use christopheraseidl\CookieConsent\Livewire\CookieConsentChanger;
use christopheraseidl\CookieConsent\Livewire\CookieConsentModal;
use christopheraseidl\CookieConsent\View\Components\CookiePolicy;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class CookieConsentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap package services.
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'cookie-consent');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cookie-consent');

        $this->publishes([
            __DIR__ . '/../resources/lang' => $this->app->langPath('christopheraseidl/cookie-consent'),
        ], 'cookie-consent-translations');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/christopheraseidl/cookie-consent')
        ], 'cookie-consent-views');

        $this->publishes([
            __DIR__ . '/../config/cookie-consent.php' => config_path('cookie-consent.php')
        ], 'cookie-consent-config');

        $this->mergeConfigFrom(
            __DIR__ . '/../config/cookie-consent.php', 'cookie-consent'
        );

        $this->publishes([
            __DIR__ . '/../resources/images' => public_path('christopheraseidl/cookie-consent/images')
        ], 'cookie-consent-images');

        $this->publishes([
            __DIR__ . '/../resources/css' => public_path('christopheraseidl/cookie-consent/css')
        ], 'cookie-consent-css');

        Livewire::component('cookie-consent', CookieConsentModal::class);

        Livewire::component('cookie-consent-changer', CookieConsentChanger::class);

        Blade::component('cookie-policy', CookiePolicy::class);

        Blade::component('cookie-consent::components.cookie', 'cookie');

        Blade::component('cookie-consent::components.close', 'close');

        AboutCommand::add('Laravel Cookie Consent', fn () => ['Version' => '1.0.0']);

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                UninstallCommand::class,
            ]);
        }
    }

    /**
     * Register any additional services later.
     */
    public function register()
    {
        // Load the service
        $this->app->scoped('cookie_consent', function (Application $app) {
            return new CookieConsentService();
        });

        // Load the configuration file if it hasn't been published
        if ($this->app['config']->get('cookie-consent') === null) {
            $this->app['config']->set('cookie-consent', require __DIR__ . '/../config/cookie-consent.php');
        }
    }
}