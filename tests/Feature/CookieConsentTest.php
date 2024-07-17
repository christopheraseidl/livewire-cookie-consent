<?php

namespace christopheraseidl\CookieConsent\Tests\Feature;

use christopheraseidl\CookieConsent\Facades\CookieConsent;
use christopheraseidl\CookieConsent\Tests\TestCase;
use christopheraseidl\CookieConsent\Traits\YieldsCookiePolicyView;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;

class CookieConsentTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        // Publish translations
        $this->artisan('vendor:publish', [
            '--tag' => 'cookie-consent-translations',
            '--force' => true
        ])->run();

        // Publish views
        $this->artisan('vendor:publish', [
            '--tag' => 'cookie-consent-views',
            '--force' => true
        ])->run();

        // Publish config
        $this->artisan('vendor:publish', [
            '--tag' => 'cookie-consent-config',
            '--force' => true
        ])->run();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        // Delete published translations.
        $this->removeDirectory(base_path('lang/christopheraseidl'));

        // Delete published views.
        $this->removeDirectory(base_path('resources/views/christopheraseidl'));

        // Delete published config.
        unlink(base_path('config/cookie-consent.php'));
    }

    /**
     * Test whether default locale cookie policy exists.
     */
    public function test_has_default_locale_policy()
    {
        $obj = new class {
            use YieldsCookiePolicyView;
        };

        $this->assertTrue(View::exists($obj->getView()));
    }

    /**
     * Test whether at least one non-default locale cookie policy exists.
     */
    public function test_has_at_least_one_translated_policy()
    {
        $obj = new class {
            use YieldsCookiePolicyView;
        };

        // Try to assert that the view exists if there is a non-default locale
        foreach (config('cookie-consent.available_locales') as $locale) {
            if ($locale != config('app.locale')) {
                App::setLocale($locale);

                return $this->assertTrue(View::exists($obj->getView()));
            }
        }

        // There is no non-default locale available
        return $this->assertTrue(false);
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
        foreach (config('cookie-consent.cookies_to_delete') as $cookie) {
            Cookie::queue(
                $cookie,
                'delicious',
                60 * 24 * 30
            );
        }

        // Refuse consent
        CookieConsent::refuse();

        // Assert the cookies have been deleted
        foreach (config('cookie-consent.cookies_to_delete') as $cookie) {
            $this->assertTrue(Cookie::get($cookie) == null);
        }
    }
}