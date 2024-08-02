<?php

namespace christopheraseidl\CookieConsent\Services\Common;

use christopheraseidl\CookieConsent\Exceptions\FileNotFoundException;
use Illuminate\Support\Facades\File;

abstract class ViteConfigModifier extends BaseCommandService
{
    /**
     * Format the updated content array contained within the Vite config file.
     */
    abstract protected function formatInputArray(string $existingContent): string;

    /**
     * Perform changes on the searched pattern in the Vite config file.
     */
    abstract protected function updateInputArray(array $matches): string;

    protected function ensureViteConfigExists(): void
    {
        if (!File::exists($this->command->config->viteConfigFilePath)) {
            throw new FileNotFoundException("The Vite config file located at " . $this->command->config->viteConfigFilePath . " has not been found.");
        }
    }

    protected function modifyViteConfig(): void
    {
        $this->command->config->viteConfigFileContents = preg_replace_callback(
            $this->command->config->vitePattern, 
            [$this, 'updateInputArray'],
            $this->command->config->viteConfigFileContents
        );
    }

    protected function displayDryRunViteOutput(): void
    {
        $this->command->info("The following Vite configuration file would be modified:");
        $this->command->line(" Location: " . $this->command->config->viteConfigFilePath);
        $this->command->line(" Contents:");
        $this->command->newLine();
        $this->command->line($this->command->config->viteConfigFileContents);
    }

    protected function saveViteConfigFile(): void
    {
        File::put($this->command->config->viteConfigFilePath, $this->command->config->viteConfigFileContents);
    }

    public function run(): bool
    {
        try {
            $this->ensureViteConfigExists();
            $this->modifyViteConfig();

            if ($this->command->isDryRun()) {
                $this->displayDryRunViteOutput();
            } else {
                $this->saveViteConfigFile();
                $this->command->info("The Vite configuration file has been successfully modified.");
            }
            return true;
        } catch (FileNotFoundException $e) {
            $this->handleFileNotFoundException($e);
            return false;
        } catch (\Exception $e) {
            $this->handleGenericException($e, "updating the Vite config");
            return false;
        }
    }
}