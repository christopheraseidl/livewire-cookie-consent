<?php

namespace christopheraseidl\CookieConsent\Tests;

use christopheraseidl\CookieConsent\Config\AssetConfig;
use christopheraseidl\CookieConsent\CookieConsentServiceProvider;
use christopheraseidl\CookieConsent\Interfaces\AssetConfigInterface;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\File;

abstract class CookieConsentTestCase extends BaseTestCase
{
    protected string $dir;

    protected AssetConfigInterface $assets;

    public function setUp(): void
    {
        parent::setUp();

        $this->disableCookieEncryption();
        $this->createTemporaryDirectory();
        $this->setUpMainConfig();
        $this->bindCustomAssetConfigToServiceContainer();
        $this->setAssets();
        $this->bootProvider();
    }

    private function createTemporaryDirectory(): void
    {
        // Create a temporary directory.
        $this->dir = sys_get_temp_dir() . '/livewire_cookie_consent_tests/test_' . md5(microtime()) . '/';
        File::makeDirectory($this->dir, 0755, true);
    }

    private function setUpMainConfig(): void
    {
        $this->app['config']->set('cookie-consent', require __DIR__ . '/../config/cookie-consent.php');
    }

    private function bindCustomAssetConfigToServiceContainer(): void
    {
        $this->app->bind(AssetConfigInterface::class, function ($app) {
            return $this->getCustomAssetConfigInstance();
        });
    }

    /**
     * Return a custom AssetConfig instance for the test.
     */
    private function getCustomAssetConfigInstance(): AssetConfigInterface
    {
        return new AssetConfig([
            // The CSS publishing path.
            'css_path' => $this->dir . 'resources/css/christopheraseidl/cookie-consent',

            // The default config publishing path.
            'default_config_path' => $this->dir . 'config/cookie-consent.php',

            // The files config publishing path.
            'files_config_path' => $this->dir . 'config/cookie-consent-files.php',

            // The images publishing path.
            'images_path' => $this->dir . 'public/christopheraseidl/cookie-consent/images',

            // The translations publishing path.
            'translations_path' => $this->dir . 'lang/christopheraseidl/cookie-consent',

            // The views publishing path.
            'views_path' => $this->dir . 'resources/views/christopheraseidl/cookie-consent'
        ]);
    }

    private function setAssets(): void
    {
        $this->assets = $this->app->make(AssetConfigInterface::class);
    }

    /**
     * Manually boot the service provider in order to override the auto-loaded instance from composer.json.
     */
    private function bootProvider(): void
    {
        $provider = new CookieConsentServiceProvider($this->app);
        $provider->boot();
    }

    protected function tearDown(): void
    {
        // Clean up the temporary directory.
        File::deleteDirectory(sys_get_temp_dir() . '/livewire_cookie_consent_tests');

        parent::tearDown();
    }

    protected function getPackageProviders($app)
    {
        return [
            \Livewire\LivewireServiceProvider::class,
            CookieConsentServiceProvider::class,
        ];
    }

    protected function putFile(string $path, string $content, int $permissions = 0755): bool
    {
        // Get the directory part of the path.
        $directory = dirname($path);

        // Check if the directory exists; if not, create it.
        if (!File::exists($directory)) {
            File::makeDirectory($directory, $permissions, true);
        }

        // Write the content to the file and return success status.
        return File::put($path, $content);
    }

    protected function setUpFilesConfig(): void
    {
        $this->app['config']->set('cookie-consent-files', require __DIR__ . '/../config/cookie-consent-files.php');
    }
}