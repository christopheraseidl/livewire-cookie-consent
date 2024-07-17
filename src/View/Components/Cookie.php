<?php

namespace christopheraseidl\CookieConsent\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Cookie extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $view = file_exists(resource_path('views/christopheraseidl/cookie-consent/components/cookie.blade.php'))
            ? 'christopheraseidl.cookie-consent.components.cookie'
            : 'cookie-consent::components.cookie';

        return view($view);
    }
}
