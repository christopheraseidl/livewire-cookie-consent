<?php

namespace christopheraseidl\CookieConsent\Livewire;

use christopheraseidl\CookieConsent\Traits\GivesAndRefusesConsent;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class CookieConsentChanger extends Component
{
    use GivesAndRefusesConsent;

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        $view = File::exists(resource_path('views/christopheraseidl/cookie-consent/livewire/cookie-consent-changer.blade.php'))
            ? 'christopheraseidl.cookie-consent.livewire.cookie-consent-changer'
            : 'cookie-consent::livewire.cookie-consent-changer';

        return view($view);
    }
}
