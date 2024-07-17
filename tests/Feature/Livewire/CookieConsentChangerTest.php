<?php

namespace christopheraseidl\CookieConsent\Tests\Feature\Livewire;

use christopheraseidl\CookieConsent\Livewire\CookieConsentChanger;
use christopheraseidl\CookieConsent\Tests\TestCase;
use Livewire\Livewire;

class CookieConsentChangerTest extends TestCase
{
    /**
     * Test whether the component shows option to enable cookies after rejection.
     */
    public function test_shows_option_to_accept_cookies_after_rejection()
    {
        Livewire::withCookie(config('cookie-consent.cookie_name'), config('cookie-consent.refuse_value'))
            ->test(CookieConsentChanger::class)
            ->assertSee(__('cookie-consent::text.consent_refused'));
    }

    /**
     * Test whether the component shows option to reject cookies after acceptance.
     */
    public function test_shows_option_to_reject_cookies_after_acceptance()
    {
        Livewire::withCookie(config('cookie-consent.cookie_name'), config('cookie-consent.consent_value'))
            ->test(CookieConsentChanger::class)
            ->assertSee(__('cookie-consent::text.consent_given'));
    }
}
