<?php

namespace christopheraseidl\CookieConsent\Services\Installation;

use christopheraseidl\CookieConsent\Services\Common\ViteConfigModifier;

class ViteConfigInjector extends ViteConfigModifier
{
    /**
     * Perform changes on the searched pattern in the Vite config file.
     */
    protected function updateInputArray(array $matches): string
    {
        $existingContent = $matches[1];

        // If the new line is already present, return the content without modifications.
        if (str_contains($existingContent, $this->command->config->viteLine)) {
            return $matches[0];
        }

        return $this->formatInputArray($existingContent);
    }

    /**
     * Format the updated content array contained within the Vite config file.
     */
    protected function formatInputArray(string $existingContent): string
    {
        $trimmedExistingContent = $this->trimTrailingWhitespaceAndComma($existingContent);
        return "input: [$trimmedExistingContent, " . $this->command->config->viteLine . "]";
    }
}