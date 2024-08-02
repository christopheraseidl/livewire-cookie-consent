<?php

namespace christopheraseidl\CookieConsent\Tests\Unit;

use christopheraseidl\CookieConsent\Tests\CookieConsentTestCase;
use christopheraseidl\CookieConsent\Tests\Traits\HandlesComponent;
use christopheraseidl\CookieConsent\View\Components\CookiePolicy;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class CookiePolicyComponentTest extends CookieConsentTestCase
{
    use HandlesComponent;

    public function setUp(): void
    {
        parent::setUp();

        // Set up views and namespace.
        $this->setUpComponent();
    }

    public function test_get_locale_returns_current_locale()
    {
        App::setLocale('fr');
        $this->assertEquals('fr', $this->component->getLocale());
    }

    public function test_get_locale_returns_config_locale_when_same_as_current()
    {
        $this->app['config']->set(['app.locale' => 'de']);
        App::setLocale('de');
        $this->assertEquals('de', $this->component->getLocale());
    }

    public function test_get_view_returns_published_view_when_exists()
    {
        $this->assertEquals(
            'christopheraseidl.cookie-consent.components.policy.en.cookie-policy',
            $this->component->getView()
        );
    }

    public function test_get_view_returns_default_view_when_published_not_exists()
    {
        File::delete($this->dir . 'resources/views/christopheraseidl/cookie-consent/components/policy/en/cookie-policy.blade.php');

        $this->assertEquals(
            'cookie-consent::components.policy.en.cookie-policy',
            $this->component->getView()
        );
    }

    public function test_render_returns_view()
    {
        $renderedView = $this->component->render();

        $this->assertStringContainsString('What are cookies?', $renderedView);
    }
}