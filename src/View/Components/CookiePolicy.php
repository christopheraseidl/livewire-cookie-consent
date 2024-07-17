<?php

namespace christopheraseidl\CookieConsent\View\Components;

use christopheraseidl\CookieConsent\Traits\YieldsCookiePolicyView;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CookiePolicy extends Component
{
    use YieldsCookiePolicyView;

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view($this->getView());
    }
}
