<?php

namespace christopheraseidl\CookieConsent\Tests\Feature;

use christopheraseidl\CookieConsent\Tests\CookieConsentTestCase;
use Illuminate\Support\Facades\File;

class AssetPublicationTest extends CookieConsentTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Publish default config
        $this->artisan('vendor:publish', [
            '--tag' => 'cookie-consent-config',
            '--force' => true
        ])->run();

        // Publish files config
        $this->artisan('vendor:publish', [
            '--tag' => 'cookie-consent-config-files',
            '--force' => true
        ])->run();

        // Publish CSS
        $this->artisan('vendor:publish', [
            '--tag' => 'cookie-consent-css',
            '--force' => true
        ])->run();

        // Publish images
        $this->artisan('vendor:publish', [
            '--tag' => 'cookie-consent-images',
            '--force' => true
        ])->run();

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
    }

    /**
     * Test whether the published default config file exists.
     */
    public function test_published_default_config_exists()
    {
        $this->assertFileExists($this->assets->defaultConfigPath);
    }

    /**
     * Test whether the published files config file exists.
     */
    public function test_published_files_config_exists()
    {
        $this->assertFileExists($this->assets->filesConfigPath);
    }

    /**
     * Test whether the css file has been published.
     */
    public function test_css_published()
    {
        $this->assertFileExists($this->assets->cssPath . '/cookie-consent.css');
    }

    /**
     * Test whether the 'cookie.svg' file has been published.
     */
    public function test_cookie_svg_published()
    {
        $this->assertFileExists($this->assets->imagesPath . '/cookie.svg');
    }

    /**
     * Test whether the 'cookie.svg' file has the correct content.
     */
    public function test_cookie_svg_has_correct_content()
    {
        $file = File::get($this->assets->imagesPath . '/cookie.svg');

        $this->assertStringStartsWith('<svg version="1.1" xmlns="http://www.w3.org/2000/svg"', $file);
        $this->assertStringEndsWith('</svg>', $file);
    }

    /**
     * Test whether the 'x.svg' file has been published.
     */
    public function test_x_svg_published()
    {
        $this->assertFileExists($this->assets->imagesPath . '/x.svg');
    }

    /**
     * Test whether the 'x.svg' file has the correct content.
     */
    public function test_x_svg_has_correct_content()
    {
        $file = File::get($this->assets->imagesPath . '/x.svg');

        $this->assertStringStartsWith('<svg xmlns="http://www.w3.org/2000/svg"', $file);
        $this->assertStringEndsWith('</svg>', $file);
    }

    /**
     * Test whether published translations exist.
     */
    public function test_published_translations_exist()
    {
        $this->assertFileExists($this->assets->translationsPath);
    }

    /**
     * Test whether translations are working.
     */
    public function test_translations_work()
    {
        $this->assertNotEquals(__('cookie-consent::text.yes'), 'cookie-consent::text.yes');
    }

    /**
     * Test whether the published view folder exists.
     */
    public function test_published_view_folder_exists()
    {
        $this->assertFileExists($this->assets->viewsPath);
    }
}