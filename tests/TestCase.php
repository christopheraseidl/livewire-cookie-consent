<?php

namespace christopheraseidl\CookieConsent\Tests;

use christopheraseidl\CookieConsent\CookieConsentServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Orchestra\Testbench\Concerns\WithWorkbench;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    protected static $testPublicImagePath;

    public function setUp(): void
    {
        $this->afterApplicationCreated(function () {
            $this->makeACleanSlate();
        });

        $this->beforeApplicationDestroyed(function () {
            $this->makeACleanSlate();
        });

        parent::setUp();

        $this->disableCookieEncryption();

        // Publish images
        $this->artisan('vendor:publish', [
            '--tag' => 'cookie-consent-images',
            '--force' => true
            ])->run();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        // Delete public directory
        $this->removeDirectory(public_path('christopheraseidl/cookie-consent'));
    }

    protected function removeDirectory(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }

        // Iterate through files and subdirectories
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $filePath = "$dir/$file";
            if (is_dir($filePath)) {
                // Recursively delete subdirectory
                $this->removeDirectory($filePath);
            } else {
                // Delete file
                unlink($filePath);
            }
        }

        // Remove the empty directory
        rmdir($dir);
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        // Remove the symbolic link
        if (! is_null(self::$testPublicImagePath)) {
            if (is_link(self::$testPublicImagePath)) {
                unlink(self::$testPublicImagePath);
            }
        }
    }

    public function makeACleanSlate()
    {
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        File::deleteDirectory($this->livewireViewsPath());
        File::deleteDirectory($this->livewireClassesPath());
        File::deleteDirectory($this->livewireTestsPath());
        File::delete(app()->bootstrapPath('cache/livewire-components.php'));
    }

    protected function getPackageProviders($app)
    {
        return [
            \Livewire\LivewireServiceProvider::class,
            CookieConsentServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('view.paths', [
            __DIR__ . '/views',
            resource_path('views'),
        ]);

        $app['config']->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');

        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('filesystems.disks.unit-downloads', [
            'driver' => 'local',
            'root' => __DIR__ . '/fixtures',
        ]);

        // Set up default package config
        $config = include realpath(__DIR__ . '/../config/cookie-consent.php');
        foreach ($config as $setting => $value) {
            $app['config']->set('cookie-consent.' . $setting, $value);
        }
    }

    protected function livewireClassesPath($path = '')
    {
        return app_path('Livewire'.($path ? '/'.$path : ''));
    }

    protected function livewireViewsPath($path = '')
    {
        return resource_path('views').'/livewire'.($path ? '/'.$path : '');
    }

    protected function livewireTestsPath($path = '')
    {
        return base_path('tests/Feature/Livewire'.($path ? '/'.$path : ''));
    }
}
