<?php

namespace christopheraseidl\CookieConsent\Tests\Unit;

use christopheraseidl\CookieConsent\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class InstallCommandTest extends TestCase
{
    /**
     * Test whether the command exists.
     */
    public function test_install_command_exists()
    {
        $commands = Artisan::all();

        $this->assertArrayHasKey('cookie-consent:install', $commands);
    }
}