<?php

namespace christopheraseidl\CookieConsent\Services\Installation;

use christopheraseidl\CookieConsent\Services\Common\TailwindConfigModifier;

class TailwindConfigInjector extends TailwindConfigModifier
{
    /**
     * Perform changes on the searched pattern in the Tailwind config file.
     */
    protected function updateContentArray(array $matches): string
    {
        $existingContent = $matches[1];

        // If the new line is already present, return the content without modifications.
        if (str_contains($existingContent, $this->command->config->tailwindLine)) {
            return $matches[0];
        }

        return $this->formatContentArray($existingContent);
    }

    /**
     * Format the updated content array contained within the Tailwind config file.
     */
    protected function formatContentArray(string $existingContent): string
    {
        $indentedExistingContent = $this->indent(2) . $this->trimTrailingWhitespaceAndComma($existingContent);
        $indentedNewLine = $this->indent(2) . $this->command->config->tailwindLine;

        return "content: [\n$indentedExistingContent,\n$indentedNewLine\n" . $this->indent() . "]";
    }
}