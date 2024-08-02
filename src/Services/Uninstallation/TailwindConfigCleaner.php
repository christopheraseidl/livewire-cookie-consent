<?php

namespace christopheraseidl\CookieConsent\Services\Uninstallation;

use christopheraseidl\CookieConsent\Services\Common\TailwindConfigModifier;

class TailwindConfigCleaner extends TailwindConfigModifier
{
    protected function updateContentArray(array $matches): string
    {
        $existingContent = $matches[1];

        if (!str_contains($existingContent, $this->command->config->tailwindLine)) {
            return $matches[0];
        }

        return $this->formatContentArray($existingContent);
    }

    protected function formatContentArray(string $existingContent): string
    {
        $existingContent = str_replace($this->command->config->tailwindLine, '', $existingContent);
        $indentedExistingContent = $this->indent(2) . $this->trimTrailingWhitespaceAndComma($existingContent);

        return "content: [\n$indentedExistingContent\n" . $this->indent() . "]";
    }
}