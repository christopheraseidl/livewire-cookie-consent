<?php

namespace christopheraseidl\CookieConsent\Tests\Feature;

use christopheraseidl\CookieConsent\Tests\CookieConsentTestCase;
use christopheraseidl\CookieConsent\Tests\Traits\HandlesComponent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use PHPUnit\Framework\Attributes\DataProvider;

class CookiePolicyTranslationTest extends CookieConsentTestCase
{
    use HandlesComponent;

    public function setUp(): void
    {
        parent::setUp();

        // Set up views and namespace.
        $this->setUpComponent();
    }

    #[DataProvider('localeProvider')]
    public function test_has_translated_policy($locale)
    {
        App::setLocale($locale);
        
        $this->assertTrue(View::exists($this->component->getView()));
    }

    public function test_falls_back_to_default_when_locale_nonexistent()
    {
        $defaultLocale = $this->app['config']->get('app.locale');
        App::setLocale('nonexistent');

        $view = $this->component->getView();
        
        $this->assertTrue(View::exists($view));
        $this->assertStringContainsString($defaultLocale, $view, 'The view should fall back to to the default locale.');
        $this->assertNotEquals('cookie-consent::components.policy.nonexistent.cookie-policy', $view, 'The view should not use the non-existent locale.');
    }

    public function test_prefers_published_view_when_available()
    {        
        $this->assertEquals($this->component->publishedView, $this->component->getView());
    }

    public static function localeProvider(): array
    {
        $policyDir = __DIR__ . '/../../resources/views/components/policy';
        $locales = array_map(function ($dir) {
            return [basename($dir)];
        }, glob($policyDir . '/*', GLOB_ONLYDIR));

        return $locales ?: [['en']]; // Fallback to 'en' if no directories found
    }
}