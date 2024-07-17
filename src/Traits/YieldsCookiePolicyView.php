<?php

namespace christopheraseidl\CookieConsent\Traits;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

/**
 * Trait YieldsCookiePolicyView
 * @package christopheraseidl\CookieConsent\Traits
 * This trait is designed for use with Blade components.
 */
trait YieldsCookiePolicyView
{
    public ?string $defaultView = null;

    public ?string $publishedView = null;

    public function __construct()
    {
        // Set default prefixes and suffices
        $defaultPrefix = 'cookie-consent::components.policy.';
        $publishedPrefix = 'christopheraseidl.cookie-consent.components.policy.';
        $suffix = '.cookie-policy';

        // For the default, unpublished view
        $this->defaultView = $defaultPrefix . $this->getLocale() . $suffix;

        // For the published view
        $this->publishedView = $publishedPrefix . $this->getLocale() . $suffix;
    }
    
    private function getLocale(): string 
    {
        return config('app.locale') == App::currentLocale()
            ? config('app.locale')
            : App::currentLocale();
    }
    
    public function getView(): string
    {
        return View::exists($this->publishedView)
            ? $this->publishedView
            : $this->defaultView;
    }
}
