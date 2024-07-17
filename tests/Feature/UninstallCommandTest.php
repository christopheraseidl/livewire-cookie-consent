<?php

namespace christopheraseidl\CookieConsent\Tests\Feature;

use christopheraseidl\CookieConsent\Tests\TestCase;

class UninstallCommandTest extends TestCase
{
    protected ?string $tailwindFile = null;

    protected string $tailwindContent = '"./vendor/christopheraseidl/**/*.blade.php"';

    protected ?string $viteFile = null;

    protected string $viteContent = "'public/christopheraseidl/cookie-consent/css/cookie-consent.css'";

    protected string $cssContent = "@import url('/public/christopheraseidl/cookie-consent/css/cookie-consent.css');";

    public function setUp(): void
    {
        parent::setUp();

        // Run the install command
        $this->artisan('cookie-consent:install')->run();

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

        // Run the uninstall command
        $this->artisan('cookie-consent:uninstall')->run();
    }

    protected function defineEnvironment($app)
    {
        parent::defineEnvironment($app);

        $this->createTailwindFile();

        $this->createViteFile();
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
                $this->tailwindContent,
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
                    input: ['resources/css/app.css', 'resources/js/app.js', $this->viteContent,],
                    refresh: true,
                }),
            ],
        });
        EOD;
        file_put_contents($this->viteFile, $content);
    }

    private function createCSSFile(): void
    {
        // Create a temporary file named app.css
        $this->cssFile = resource_path('css/app.css');
        // Create a temporary file named app.css
        $this->cssFile = resource_path('css/app.css');
        $content = <<<EOD
        $this->cssContent
        
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
    }

    /**
     * Test whether the Tailwind file has been amended.
     */
    public function test_tailwind_file_trimmed()
    {
        // Assertions to ensure the command worked as expected
        $this->assertStringNotContainsString(
            $this->tailwindContent,
            file_get_contents($this->tailwindFile)
        );
    }

    /**
     * Test whether the Vite file has been amended.
     */
    public function test_vite_file_trimmed()
    {
        $this->assertStringNotContainsString(
            $this->viteContent,
            file_get_contents($this->viteFile)
        );
    }

    /**
     * Test whether the Vite file has been amended.
     */
    public function test_app_css_file_trimmed()
    {
        $this->assertStringNotContainsString(
            $this->cssContent,
            file_get_contents($this->viteFile)
        );
    }

    /**
     * Test whether the public directory has been deleted.
     */
    public function test_public_directory_deleted()
    {
        $this->assertTrue(! is_dir(public_path('christopheraseidl/cookie-consent')));
    }

    /**
     * Test whether the translations directory has been deleted.
     */
    public function test_translations_directory_deleted()
    {
        $this->assertTrue(! is_dir($this->app->langPath('christopheraseidl/cookie-consent')));
    }

    /**
     * Test whether the views directory has been deleted.
     */
    public function test_views_directory_deleted()
    {
        $this->assertTrue(! is_dir(resource_path('views/christopheraseidl/cookie-consent')));
    }

    /**
     * Test whether the config file has been deleted.
     */
    public function test_config_file_deleted()
    {
        $this->assertTrue(! file_exists(config_path('cookie-consent.php')));
    }
}