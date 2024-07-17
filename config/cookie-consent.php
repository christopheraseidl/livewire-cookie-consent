<?php

    return [
        'cookie_name'             => 'cas_laravel_cookie_consent',
        'cookies_to_delete'       => [],
        'consent_value'           => 'yes',
        'refuse_value'            => 'no',
        'enabled'                 => true,
        'consent_cookie_lifetime' => 60 * 24 * 365,
        'refuse_cookie_lifetime'  => 60 * 24 * 30,
        'available_locales'       => ['en', 'es'],
    ];
