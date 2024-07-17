<?php

namespace christopheraseidl\CookieConsent\Facades;

use Illuminate\Support\Facades\Facade;

class CookieConsent extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cookie_consent';
    }
}