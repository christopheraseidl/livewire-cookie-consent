<?php

namespace christopheraseidl\CookieConsent\Traits;

use christopheraseidl\CookieConsent\Facades\CookieConsent;
use Illuminate\Http\Request;

trait GivesAndRefusesConsent
{
    public bool $consentGiven = false;

    public bool $consentRefused = false;

    public function bootGivesAndRefusesConsent(Request $request): void
    {
        $this->setServiceCookie($request);
        $this->setConsent();
    }

    protected function setServiceCookie(Request $request): void
    {
        $value = $request->cookie(config('cookie-consent.cookie_name'));

        if (! is_null($value)) {
            CookieConsent::setCookie($value);
        }
    }

    protected function setConsent(): void
    {
        if (CookieConsent::consentGiven()) {
            $this->consentGiven = true;
        } elseif (CookieConsent::consentRefused()) {
            $this->consentRefused = true;
        }
    }

    public function giveConsent(): void
    {
        CookieConsent::consent();
        $this->consentGiven = true;
        $this->consentRefused = false;
    }

    public function refuseConsent(): void
    {
        CookieConsent::refuse();
        $this->consentRefused = true;
        $this->consentGiven = false;
    }
}