<?php

namespace christopheraseidl\CookieConsent\Tests\Feature;

use christopheraseidl\CookieConsent\Tests\TestCase;

class InstallCommandTest extends TestCase
{
    protected $tailwindFile = null;

    protected $viteFile = null;

    protected $cssFile = null;

    public function setUp(): void
    {
        parent::setUp();

        // Run the install command
        $this->artisan('cookie-consent:install')->run();
    }

    protected function defineEnvironment($app)
    {
        parent::defineEnvironment($app);

        $this->createTailwindFile();

        $this->createViteFile();

        $this->createCSSFile();
    }

    private function createTailwindFile(): void
    {
        // Create a temporary file named tailwind.config.js
        $this->tailwindFile = base_path('tailwind.config.js');
        $content = <<<EOD
        /** @type {import('tailwindcss').Config} */
        export default {
            content: [
                "./resources/**/*.blade.php",
                "./resources/**/*.js",
                "./resources/**/*.vue",
            ],
            theme: {
                extend: {},
            },
            plugins: [],
        }
        EOD;
        file_put_contents($this->tailwindFile, $content);
    }

    private function createViteFile(): void
    {
        // Create a temporary file named vite.config.js
        $this->viteFile = base_path('vite.config.js');
        $content = <<<EOD
        import { defineConfig } from 'vite';
        import laravel from 'laravel-vite-plugin';
        
        export default defineConfig({
            plugins: [
                laravel({
                    input: ['resources/css/app.css', 'resources/js/app.js',],
                    refresh: true,
                }),
            ],
        });
        EOD;
        file_put_contents($this->viteFile, $content);
    }

    private function createCSSFile(): void
    {
        // Make the directory if it doesn't exist.
        $directory = resource_path('css');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Create a temporary file named app.css
        $this->cssFile = resource_path('css/app.css');
        $content = <<<EOD
        @tailwind base;
        @tailwind components;
        @tailwind utilities;
        EOD;
        file_put_contents($this->cssFile, $content);
    }

    public function tearDown(): void
    {
        // Clean up after each test
        parent::tearDown();

        // Clean up temporary files
        unlink($this->tailwindFile);
        unlink($this->viteFile);
        $this->removeDirectory(resource_path('css'));

        // Remove the package's directory in public_path()
        $this->removeDirectory(public_path('christopheraseidl/cookie-consent'));
    }

    /**
     * Test whether the Tailwind file has been amended.
     */
    public function test_tailwind_file_amended()
    {
        // Assertions to ensure the command worked as expected
        $this->assertStringContainsString(
            '"./vendor/christopheraseidl/**/*.blade.php"',
            file_get_contents($this->tailwindFile)
        );
    }

    /**
     * Test whether the Vite file has been amended.
     */
    public function test_vite_file_amended()
    {
        $this->assertStringContainsString(
            "'public/christopheraseidl/cookie-consent/css/cookie-consent.css'",
            file_get_contents($this->viteFile)
        );
    }

    /**
     * Test whether the CSS file has been amended.
     */
    public function test_app_css_file_amended()
    {
        $this->assertStringContainsString(
            "@import url('/public/christopheraseidl/cookie-consent/css/cookie-consent.css');",
            file_get_contents($this->cssFile)
        );
    }

    /**
     * Test whether the images directory gets created.
     */
    public function test_creates_images_directory()
    {
        $this->assertTrue(is_dir(public_path('christopheraseidl/cookie-consent/images')));
    }

    /**
     * Test whether the css directory gets created.
     */
    public function test_creates_css_directory()
    {
        $this->assertTrue(is_dir(public_path('christopheraseidl/cookie-consent/css')));
    }
}