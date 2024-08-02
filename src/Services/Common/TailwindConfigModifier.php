<?php

namespace christopheraseidl\CookieConsent\Services\Common;

use christopheraseidl\CookieConsent\Exceptions\FileNotFoundException;
use Illuminate\Support\Facades\File;

abstract class TailwindConfigModifier extends BaseCommandService
{
    /**
     * Format the updated content array contained within the Tailwind config file.
     */
    abstract protected function formatContentArray(string $existingContent): string;

    /**
     * Perform changes on the searched pattern in the Tailwind config file.
     */
    abstract protected function updateContentArray(array $matches): string;

    protected function displayDryRunTailwindOutput(): void
    {
        $this->command->info("The Tailwind configuration file would be modified:");
        $this->command->line(" Location: " . $this->command->config->tailwindConfigFilePath);
        $this->command->line(" Contents:");
        $this->command->newLine();
        $this->command->line($this->command->config->tailwindConfigFileContents);
    }

    protected function ensureTailwindConfigExists(): void
    {
        if (!File::exists($this->command->config->tailwindConfigFilePath)) {
            throw new FileNotFoundException("The Tailwind config file located at " . $this->command->config->tailwindConfigFilePath . " has not been found.");
        }
    }

    protected function modifyTailwindConfig(): void
    {
        $this->command->config->tailwindConfigFileContents = preg_replace_callback(
            $this->command->config->tailwindPattern, 
            [$this, 'updateContentArray'],
            $this->command->config->tailwindConfigFileContents
        );
    }

    protected function saveTailwindConfigFile(): void
    {
        File::put($this->command->config->tailwindConfigFilePath, $this->command->config->tailwindConfigFileContents);
    }

    public function run(): bool
    {
        try {
            $this->ensureTailwindConfigExists();
            $this->modifyTailwindConfig();

            if ($this->command->isDryRun()) {
                $this->displayDryRunTailwindOutput();
            } else {
                $this->saveTailwindConfigFile();
                $this->command->info("The Tailwind configuration file has been successfully modified.");
            }
            return true;
        } catch (FileNotFoundException $e) {
            $this->handleFileNotFoundException($e);
            return false;
        } catch (\Exception $e) {
            $this->handleGenericException($e, "updating the Tailwind config");
            return false;
        }
    }
}