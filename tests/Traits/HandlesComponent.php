<?php

namespace christopheraseidl\CookieConsent\Tests\Traits;

use christopheraseidl\CookieConsent\View\Components\CookiePolicy;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

trait HandlesComponent
{
    private CookiePolicy $component;

    public function setUpComponent(): void
    {
        $this->addViewLocation();
        $this->addViewNamespace();
        $this->copyCookiePolicies();

        $this->component = new CookiePolicy();
    }
    /**
     * Adjust view paths to include the temporary directory.
     */
    public function addViewLocation(): void
    {
        View::addLocation($this->dir . 'resources/views');
    }

    /**
     * Adjust the view namespace for the package.
     */
    public function addViewNamespace(): void
    {
        View::addNamespace('cookie-consent', $this->dir . '/vendor/christopheraseidl/cookie-consent/resources/views');
    }

    public function copyCookiePolicies(): void
    {
        File::copyDirectory(__DIR__ . '/../../resources/views/components/policy', $this->dir . 'resources/views/christopheraseidl/cookie-consent/components/policy');
    }
}