<?php

namespace christopheraseidl\CookieConsent\Livewire;

use christopheraseidl\CookieConsent\Facades\CookieConsent;
use christopheraseidl\CookieConsent\Traits\GivesAndRefusesConsent;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class CookieConsentModal extends Component
{
    use GivesAndRefusesConsent {
        giveConsent as consent;
        refuseConsent as refuse;
    }

    public bool $seekingConsent = false;

    public bool $openConsentModal = false;

    public bool $openCookieModal = false;

    public ?string $text = null;

    public function mount()
    {
        $this->seekingConsent = ! CookieConsent::cookieExists();
        $this->openConsentModal = true;
    }

    public function render()
    {
        $view = File::exists(resource_path('views/christopheraseidl/cookie-consent/livewire/cookie-consent-modal.blade.php'))
            ? 'christopheraseidl.cookie-consent.livewire.cookie-consent-modal'
            : 'cookie-consent::livewire.cookie-consent-modal';

        return view($view);
    }

    public function rendered()
    {
        if (! CookieConsent::consentGiven() || CookieConsent::consentRefused()) {
            CookieConsent::deleteCookies();
        }
    }

    public function toggleCookieModal()
    {
        $this->openCookieModal = !$this->openCookieModal;
        $this->openConsentModal = !$this->openConsentModal;
        $this->toggleScroll();
    }

    public function giveConsent()
    {
        $this->consent();
        $this->openConsentModal = false;
        $this->seekingConsent = false;
    }

    public function refuseConsent()
    {
        $this->refuse();
        $this->openConsentModal = false;
        $this->seekingConsent = false;
    }

    public function toggleScroll() {
        $this->dispatch($this->getToggleAction() . 'scroll');
    }

    private function getToggleAction() {
        return $this->openCookieModal ? 'hide' : 'show';
    }
}
