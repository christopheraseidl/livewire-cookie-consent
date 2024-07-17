<?php

namespace christopheraseidl\CookieConsent\Tests\Feature\Livewire;

use christopheraseidl\CookieConsent\CookieConsentMiddleware;
use christopheraseidl\CookieConsent\Livewire\CookieConsentModal;
use christopheraseidl\CookieConsent\Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Livewire\Livewire;

class CookieConsentModalTest extends TestCase
{
    /**
     * Test whether the modal doesn't show when disabled via config.
     */
    public function test_does_not_show_consent_modal_when_disabled()
    {
        Config::set('cookie-consent.enabled', false);

        Livewire::test(CookieConsentModal::class)
            ->assertDontSee('id="cookie-consent-modal"');
    }

    /**
     * Test whether the modal shows when consent is not confirmed and is enabled.
     */
    public function test_shows_consent_modal_if_no_consent_confirmation_and_enabled()
    {
        $request = new Request();

        $middleware = new CookieConsentMiddleware();

        $result = $middleware->handle($request, function ($request) {
            return (new Response())->setContent('<html><head></head><body></body></html>');
        });

        $content = $result->getContent();

        $this->assertStringContainsString('id="cookie-consent-modal-body"', $content);
    }

    /**
     * Test whether the modal doesn't show when consent already given.
     */
    public function test_does_not_show_consent_modal_after_consent_given()
    {
        $request = new Request();

        $middleware = new CookieConsentMiddleware();

        $result = $middleware->handle($request, function ($request) {
            return (new Response())->withCookie(config('cookie-consent.cookie_name'), config('cookie-consent.consent_value'))
                ->setContent('<html><head></head><body></body></html>');
        });

        $content = $result->getContent();

        $this->assertStringNotContainsString('id="cookie-consent-modal-body"', $content);
    }

    /**
     * Test whether the modal doesn't show when consent already refused.
     */
    public function test_does_not_show_consent_modal_after_consent_refused()
    {
        $request = new Request();

        $middleware = new CookieConsentMiddleware();

        $result = $middleware->handle($request, function ($request) {
            return (new Response())->withCookie(config('cookie-consent.cookie_name'), config('cookie-consent.refuse_value'))
                ->setContent('<html><head></head><body></body></html>');
        });

        $content = $result->getContent();

        $this->assertStringNotContainsString('id="cookie-consent-modal-body"', $content);
    }

    /**
     * Test does not show modal if body tag not found
     */
    public function test_does_not_show_modal_if_body_tag_not_found()
    {
        $request = new Request();

        $middleware = new CookieConsentMiddleware();

        $result = $middleware->handle($request, function ($request) {
            return (new Response())->setContent('<html></html>');
        });

        $content = $result->getContent();

        $this->assertStringNotContainsString('id="cookie-consent-modal"', $content);
    }
}
