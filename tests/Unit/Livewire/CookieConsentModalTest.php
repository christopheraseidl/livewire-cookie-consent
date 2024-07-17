<?php

namespace christopheraseidl\CookieConsent\Tests\Unit\Livewire;

use christopheraseidl\CookieConsent\Livewire\CookieConsentModal;
use christopheraseidl\CookieConsent\Tests\TestCase;
use Livewire\Livewire;

class CookieConsentModalTest extends TestCase
{
    /**
     * Test whether the component renders successfully.
     */
    public function test_renders_successfully()
    {
        Livewire::test(CookieConsentModal::class)
            ->assertStatus(200);
    }
}
