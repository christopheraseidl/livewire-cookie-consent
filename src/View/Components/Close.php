<?php

namespace christopheraseidl\CookieConsent\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\View\Component;

class Close extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $view = File::exists(resource_path('views/christopheraseidl/cookie-consent/components/close.blade.php'))
            ? 'christopheraseidl.cookie-consent.components.close'
            : 'cookie-consent::components.close';

        return view($view);
    }
}
