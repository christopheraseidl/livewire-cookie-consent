<?php

namespace christopheraseidl\CookieConsent\View\Components;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\View\Component;

class CookiePolicy extends Component
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
    
    public function getLocale(): string 
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

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\Contracts\View\View|Closure|string
    {
        return view($this->getView());
    }
}
