<?php

namespace christopheraseidl\CookieConsent\Services\Installation;

use christopheraseidl\CookieConsent\Services\Common\CSSFileModifier;

class CSSFileInjector extends CSSFileModifier
{
    protected function modifyCSSFile(): void
    {
        if (str_contains($this->command->config->cssFileContents, $this->command->config->cssLine)) {
            return;
        }

        $this->command->config->cssFileContents = $this->formatCSSContents($this->command->config->cssFileContents);
    }

    protected function formatCSSContents(string $content): string
    {
        return $this->command->config->cssLine . "\n\n" . trim($content);
    }
}