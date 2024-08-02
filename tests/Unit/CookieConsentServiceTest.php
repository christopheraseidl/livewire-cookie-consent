<?php

namespace christopheraseidl\CookieConsent\Tests\Unit;

use christopheraseidl\CookieConsent\CookieConsentService;
use christopheraseidl\CookieConsent\Facades\CookieConsent;
use christopheraseidl\CookieConsent\Tests\CookieConsentTestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CookieConsentServiceTest extends CookieConsentTestCase
{
    protected CookieConsentService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(CookieConsentService::class);
    }

    /**
     * Test whether the desired cookies are deleted when consent is refused.
     */
    public function test_deletes_desired_cookies_when_consent_refused()
    {
        // Array of mock cookie names to delete
        $this->app['config']->set('cookie-consent.cookies_to_delete', [
            'chocolate_chip',
            'oatmeal',
            'peanut_butter',
            ]);

        // Create the cookies
        foreach ($this->app['config']->get('cookie-consent.cookies_to_delete') as $cookie) {
            Cookie::queue(
                $cookie,
                'delicious',
                60 * 24 * 30
            );
        }

        // Refuse consent
        CookieConsent::refuse();

        // Assert the cookies have been deleted
        foreach ($this->app['config']->get('cookie-consent.cookies_to_delete') as $cookie) {
            $this->assertTrue(Cookie::get($cookie) == null);
        }
    }

    public function test_cookie_exists()
    {
        $this->assertFalse($this->service->cookieExists());
        
        $this->service->setCookie('test');
        
        $this->assertTrue($this->service->cookieExists());
    }

    public function test_consent_given()
    {
        $this->app['config']->set('cookie-consent.consent_value', 'yes');
        
        $this->service->setCookie('no');
        $this->assertFalse($this->service->consentGiven());
        
        $this->service->setCookie('yes');
        $this->assertTrue($this->service->consentGiven());
    }

    public function test_consent_refused()
    {
        $this->app['config']->set('cookie-consent.refuse_value', 'no');
        
        $this->service->setCookie('yes');
        $this->assertFalse($this->service->consentRefused());
        
        $this->service->setCookie('no');
        $this->assertTrue($this->service->consentRefused());
    }

    public function test_consent_sets_cookie()
    {
        $this->service->consent();

        $this->assertNotNull(Cookie::getQueuedCookies('consent_cookie'));
        $queuedCookie = Cookie::getQueuedCookies('consent_cookie')[0];
        $this->assertEquals('yes', $queuedCookie->getValue());
        $this->assertEquals(31536000, $queuedCookie->getMaxAge());
    }

    public function test_get_cookie_from_request()
    {
        $cookie = $this->app['config']->get('cookie-consent.cookie_name');
        
        $request = new Request();
        $request->cookies->set($cookie, 'test_value');
        $this->app->instance('request', $request);

        $this->assertEquals('test_value', $this->service->getCookieFromRequest());
    }
}