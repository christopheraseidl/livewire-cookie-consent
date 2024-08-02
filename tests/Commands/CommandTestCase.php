<?php

namespace christopheraseidl\CookieConsent\Tests\Commands;

use christopheraseidl\CookieConsent\Config\CommandConfig;
use christopheraseidl\CookieConsent\Interfaces\CommandConfigInterface;
use christopheraseidl\CookieConsent\Tests\CookieConsentTestCase;

abstract class CommandTestCase extends CookieConsentTestCase
{
    protected string $cssFilePath;
    protected string $tailwindFilePath;
    protected string $viteFilePath;

    protected string $cssContent;
    protected string $tailwindContent;
    protected string $viteContent;

    protected abstract function getCSSFileContents(): string;

    protected abstract function getTailwindFileContents(): string;

    protected abstract function getViteFileContents(): string;

    protected abstract function runCommand(): void;

    protected function bindCustomCommandConfigToServiceContainer(): void
    {
        $this->app->instance(CommandConfigInterface::class, $this->getCustomCommandConfigInstance());
    }

    /**
     * Return a custom CommandConfig instance for the test.
     */
    private function getCustomCommandConfigInstance(): CommandConfigInterface
    {
        return new CommandConfig([
            'app_css_file_path' => $this->cssFilePath,
            'tailwind_config_file_path' => $this->tailwindFilePath,
            'vite_config_file_path' => $this->viteFilePath,
        ]);
    }

    protected function createTemporaryFiles(): void
    {
        // Create the CSS file.
        $this->cssFilePath = $this->dir . 'resources/css/app.css';
        $this->putFile($this->cssFilePath, $this->getCSSFileContents());

        // Create the Tailwind file.
        $this->tailwindFilePath = $this->dir . 'tailwind.config.js';
        $this->putFile($this->tailwindFilePath, $this->getTailwindFileContents());

        // Create the Vite file.
        $this->viteFilePath = $this->dir . 'vite.config.js';
        $this->putFile($this->viteFilePath, $this->getViteFileContents());
    }

    protected function defineFileContents(): void
    {
        $this->cssContent = "@import url('/resources/css/christopheraseidl/cookie-consent/cookie-consent.css');";
        $this->tailwindContent = '"./vendor/christopheraseidl/**/*.blade.php"';
        $this->viteContent = "'resources/css/christopheraseidl/cookie-consent/cookie-consent.css'";
    }
}