<?php

namespace christopheraseidl\CookieConsent;

use christopheraseidl\CookieConsent\Facades\CookieConsent;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CookieConsentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (! config('cookie-consent.enabled')) {
            return $response;
        }

        if (! $response instanceof Response) {
            return $response;
        }

        if (! $this->containsBodyTag($response)) {
            return $response;
        }

        $this->setServiceCookie($response);

        return $this->addComponentToResponse($response);
    }

    protected function setServiceCookie(Response $response): void
    {
        foreach ($response->headers->getCookies() as $cookie) {
            if ($cookie instanceof \Symfony\Component\HttpFoundation\Cookie) {
                if ($cookie->getName() == config('cookie-consent.cookie_name')) {
                    CookieConsent::setCookie($cookie->getValue());
                }
            }
        }
    }

    protected function containsBodyTag(Response $response): bool
    {
        return $this->getLastClosingBodyTagPosition($response->getContent()) !== false;
    }

    protected function addComponentToResponse(Response $response): Response
    {
        $content = $response->getContent();

        $lastClosingBodyTagPosition = $this->getLastClosingBodyTagPosition($content);

        $content = substr($content, 0, $lastClosingBodyTagPosition)
            . app('livewire')->mount('cookie-consent')
            . substr($content, $lastClosingBodyTagPosition);

        return $response->setContent($content);
    }

    protected function getLastClosingBodyTagPosition(string $content = ''): bool|int
    {
        return strripos($content, '</body>');
    }

}