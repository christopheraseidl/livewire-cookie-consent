<?php

namespace christopheraseidl\CookieConsent\Tests\Commands;

use christopheraseidl\CookieConsent\Commands\InstallCommand;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InstallCommandTest extends CommandTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->defineFileContents();
        $this->createTemporaryFiles();
        $this->setUpFilesConfig();
        $this->bindCustomCommandConfigToServiceContainer();
        $this->runCommand();
    }

    protected function getCSSFileContents(): string
    {
        return <<<EOD
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
                    input: ['resources/css/app.css', 'resources/js/app.js',],
                    refresh: true,
                }),
            ],
        });
        EOD;
    }

    protected function runCommand(): void
    {
        $this->artisan('cookie-consent:install')->run();
    }

    /**
     * Test whether the command exists.
     */
    public function test_install_command_exists()
    {
        $commands = Artisan::all();

        $this->assertArrayHasKey('cookie-consent:install', $commands);
    }

    public function test_custom_css_file_path_is_correct()
    {
        // Create an instance of the InstallCommand.
        $command = $this->app->make(InstallCommand::class);


        // Assert that the custom CSS path is correctly set.
        $this->assertEquals($this->cssFilePath, $command->config->appCssFilePath);

        // Assert that the file exists.
        $this->assertTrue(File::exists($this->cssFilePath));
    }

    public function test_custom_tailwind_file_path_is_correct()
    {
        // Create an instance of the InstallCommand.
        $command = $this->app->make(InstallCommand::class);


        // Assert that the custom CSS path is correctly set.
        $this->assertEquals($this->tailwindFilePath, $command->config->tailwindConfigFilePath);

        // Assert that the file exists.
        $this->assertTrue(File::exists($this->tailwindFilePath));
    }

    public function test_custom_vite_file_path_is_correct()
    {
        // Create an instance of the InstallCommand.
        $command = $this->app->make(InstallCommand::class);


        // Assert that the custom CSS path is correctly set.
        $this->assertEquals($this->viteFilePath, $command->config->viteConfigFilePath);

        // Assert that the file exists.
        $this->assertTrue(File::exists($this->viteFilePath));
    }

    /**
     * Test whether the CSS file has been amended.
     */
    public function test_app_css_file_amended()
    {
        $this->assertStringContainsString(
            $this->cssContent,
            File::get($this->cssFilePath)
        );
    }

    /**
     * Test whether the Tailwind file has been amended.
     */
    public function test_tailwind_file_amended()
    {
        $this->assertStringContainsString(
            $this->tailwindContent,
            File::get($this->tailwindFilePath)
        );
    }

    /**
     * Test whether the Vite file has been amended.
     */
    public function test_vite_file_amended()
    {
        $this->assertStringContainsString(
            $this->viteContent,
            File::get($this->viteFilePath)
        );
    }
}