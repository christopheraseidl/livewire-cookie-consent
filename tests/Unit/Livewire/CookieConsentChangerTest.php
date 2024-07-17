<?php

namespace christopheraseidl\CookieConsent\Tests\Unit\Livewire;

use christopheraseidl\CookieConsent\Livewire\CookieConsentChanger;
use christopheraseidl\CookieConsent\Tests\TestCase;
use Livewire\Livewire;

class CookieConsentChangerTest extends TestCase
{
    /**
     * Test that the component renders successfully.
     */
    public function test_renders_successfully()
    {
        Livewire::test(CookieConsentChanger::class)
            ->assertStatus(200);
    }
}
