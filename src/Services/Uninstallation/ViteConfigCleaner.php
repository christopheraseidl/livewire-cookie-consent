<?php

namespace christopheraseidl\CookieConsent\Services\Uninstallation;

use christopheraseidl\CookieConsent\Services\Common\ViteConfigModifier;

class ViteConfigCleaner extends ViteConfigModifier
{
    /**
     * Perform changes on the searched pattern in the Vite config file.
     */
    protected function updateInputArray(array $matches): string
    {
        $existingContent = $matches[1];

        // If the new line isn't present, return the content without modifications.
        if (!str_contains($existingContent, $this->command->config->viteLine)) {
            return $matches[0];
        }

        return $this->formatInputArray($existingContent);
    }

    /**
     * Format the updated content array contained within the Vite config file.
     */
    protected function formatInputArray(string $existingContent): string
    {
        $existingContent = str_replace($this->command->config->viteLine, '', $existingContent);
        $indentedExistingContent = $this->indent(2) . $this->trimTrailingWhitespaceAndComma($existingContent);

        return "input: [\n$indentedExistingContent\n" . $this->indent() . "]";
    }
}