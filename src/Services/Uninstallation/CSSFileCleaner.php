<?php

namespace christopheraseidl\CookieConsent\Services\Uninstallation;

use christopheraseidl\CookieConsent\Services\Common\CSSFileModifier;

class CSSFileCleaner extends CSSFileModifier
{
    protected function modifyCSSFile(): void
    {
        if (!str_contains($this->command->config->cssFileContents, $this->command->config->cssLine)) {
            return;
        }

        $this->command->config->cssFileContents = $this->formatCSSContents($this->command->config->cssFileContents);
    }

    protected function formatCSSContents(string $content): string
    {
        $css = str_replace($this->command->config->cssLine, '', $content);
        return trim($css);
    }
}