<?php

namespace christopheraseidl\CookieConsent;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;

class CookieConsentService
{
    private ?string $cookie = null;

    public function cookieExists(): bool
    {
        return ! is_null($this->cookie);
    }

    public function consentGiven(): bool
    {
        return $this->cookie == config('cookie-consent.consent_value');
    }

    public function consentRefused(): bool
    {
        return $this->cookie == config('cookie-consent.refuse_value');
    }

    public function consent(): void
    {
        Cookie::queue(
            config('cookie-consent.cookie_name'),
            config('cookie-consent.consent_value'),
            config('cookie-consent.consent_cookie_lifetime')
        );
    }

    public function refuse(): void
    {
        Cookie::queue(
            config('cookie-consent.cookie_name'),
            config('cookie-consent.refuse_value'),
            config('cookie-consent.refuse_cookie_lifetime')
        );

        $this->deleteCookies();
    }

    public function deleteCookies(): void
    {
        foreach (config('cookie-consent.cookies_to_delete') as $cookie) {
            Cookie::queue(
                Cookie::forget($cookie)
            );
        }
    }

    public function getCookie(): ?string
    {
        return $this->cookie;
    }

    public function setCookie(string $value): void
    {
        $this->cookie = $value;
    }

    public function getCookieFromRequest(): array|null|string
    {
        return Request::cookie(config('cookie-consent.cookie_name'));
    }

    public function getConsentValue(): string
    {
        return config('cookie-consent.consent_value');
    }

    public function getRefuseValue(): string
    {
        return config('cookie-consent.refuse_value');
    }
}
