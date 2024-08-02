<?php

namespace christopheraseidl\CookieConsent\Tests\Commands;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class UninstallCommandTest extends CommandTestCase
{
    protected string $defaultConfigFilePath;
    protected string $filesConfigFilePath;
    protected string $cookieImgFilePath;
    protected string $xImgFilePath;
    protected string $translationsDirPath;
    protected string $viewsDirPath;

    public function setUp(): void
    {
        parent::setUp();

        $this->defineFileContents();
        $this->createTemporaryFiles();
        $this->setUpFilesConfig();
        $this->bindCustomCommandConfigToServiceContainer();
        $this->runCommand();
    }
    
    protected function createTemporaryFiles(): void
    {
        parent::createTemporaryFiles();

        // Create temporary default config file
        $this->defaultConfigFilePath = $this->dir . 'config/cookie-consent.php';
        $this->putFile($this->defaultConfigFilePath, File::get(__DIR__ . '/../../config/cookie-consent.php'));

        // Create temporary files config file
        $this->filesConfigFilePath = $this->dir . 'config/cookie-consent-files.php';
        $this->putFile($this->filesConfigFilePath, File::get(__DIR__ . '/../../config/cookie-consent-files.php'));

        // Create temporary cookie image
        $this->cookieImgFilePath = $this->dir . 'christopheraseidl/cookie-consent/images/cookie.svg';
        $this->putFile($this->cookieImgFilePath, File::get(__DIR__ . '/../../resources/images/cookie.svg'));

        // Create temporary 'x' image
        $this->xImgFilePath = $this->dir . 'christopheraseidl/cookie-consent/images/x.svg';
        $this->putFile($this->xImgFilePath, File::get(__DIR__ . '/../../resources/images/x.svg'));
        
        // Create temporary translations folder
        $this->translationsDirPath = $this->dir . 'lang/christopheraseidl/cookie-consent';
        File::makeDirectory($this->translationsDirPath, 0755, true);
        
        // Create temporary views folder
        $this->viewsDirPath = $this->dir . 'resources/views/christopheraseidl/cookie-consent';
        File::makeDirectory($this->viewsDirPath, 0755, true);
    }

    protected function getCSSFileContents(): string
    {
        return <<<EOD
        $this->cssContent
        
        @tailwind base;
        @tailwind components;
        @tailwind utilities;
        EOD;
    }

    protected function getTailwindFileContents(): string
    {
        return <<<EOD
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
    }

    protected function getViteFileContents(): string
    {
        return <<<EOD
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
    }

    protected function runCommand(): void
    {
        $this->artisan('cookie-consent:uninstall')->run();
    }

    /**
     * Test whether the command exists.
     */
    public function test_uninstall_command_exists()
    {
        $commands = Artisan::all();

        $this->assertArrayHasKey('cookie-consent:uninstall', $commands);
    }

    /**
     * Test whether the Vite file has been amended.
     */
    public function test_app_css_file_trimmed()
    {
        $this->assertStringNotContainsString(
            $this->cssContent,
            File::get($this->cssFilePath)
        );
    }

    /**
     * Test whether the Tailwind file has been amended.
     */
    public function test_tailwind_file_trimmed()
    {
        // Assertions to ensure the command worked as expected
        $this->assertStringNotContainsString(
            $this->tailwindContent,
            File::get($this->tailwindFilePath)
        );
    }

    /**
     * Test whether the Vite file has been amended.
     */
    public function test_vite_file_trimmed()
    {
        $this->assertStringNotContainsString(
            $this->viteContent,
            File::get($this->viteFilePath)
        );
    }

    /**
     * Test whether the public directory has been deleted.
     */
    public function test_public_directory_deleted()
    {
        $this->assertTrue(! is_dir($this->dir . 'public/christopheraseidl/cookie-consent'));
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
        $this->assertTrue(! File::exists(config_path('cookie-consent.php')));
    }
}