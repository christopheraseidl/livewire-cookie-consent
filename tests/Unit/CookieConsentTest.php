<?php

namespace christopheraseidl\CookieConsent\Tests\Unit;

use christopheraseidl\CookieConsent\Tests\TestCase;

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
        $this->removeDirectory(resource_path('views/christopheraseidl'));

        // Delete published config.
        unlink(base_path('config/cookie-consent.php'));
    }

    /**
     * Test whether translations are working.
     */
    public function test_has_translations()
    {
        $this->assertNotEquals(__('cookie-consent::text.yes'), 'cookie-consent::text.yes');
    }

    /**
     * Test whether the 'x.svg' file exists.
     */
    public function test_x_svg_exists()
    {
        $this->assertFileExists(public_path('christopheraseidl/cookie-consent/images/x.svg'));
    }

    /**
     * Test whether the 'x.svg' has the correct content.
     */
    public function test_x_svg_has_correct_content()
    {
        $file = file_get_contents(public_path('christopheraseidl/cookie-consent/images/x.svg'));

        $this->assertStringStartsWith('<svg xmlns="http://www.w3.org/2000/svg"', $file);
        $this->assertStringEndsWith('</svg>', $file);
    }

    /**
     * Test whether the 'cookie.svg' file exists.
     */
    public function test_cookie_svg_exists()
    {
        $this->assertFileExists(public_path('christopheraseidl/cookie-consent/images/cookie.svg'));
    }

    /**
     * Test whether the 'cookie.svg' has the correct content.
     */
    public function test_cookie_svg_has_correct_content()
    {
        $file = file_get_contents(public_path('christopheraseidl/cookie-consent/images/cookie.svg'));

        $this->assertStringStartsWith('<svg version="1.1" xmlns="http://www.w3.org/2000/svg"', $file);
        $this->assertStringEndsWith('</svg>', $file);
    }

    /**
     * Test whether the published config file exists.
     */
    public function test_config_file_exists()
    {
        $this->assertFileExists(config_path('cookie-consent.php'));
    }

    /**
     * Test whether the published view folder exists.
     */
    public function test_view_folder_exists()
    {
        $this->assertFileExists(resource_path('views/christopheraseidl'));
    }
}