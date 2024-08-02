<?php

namespace christopheraseidl\CookieConsent\Services\Common;

use christopheraseidl\CookieConsent\Exceptions\FileNotFoundException;
use Illuminate\Support\Facades\File;

abstract class CSSFileModifier extends BaseCommandService
{
    abstract protected function formatCSSContents(string $content): string;

    abstract protected function modifyCSSFile(): void;
    
    protected function displayDryRunCSSOutput(): void
    {
        $this->command->info("The app.css file would be modified:");
        $this->command->line(" Location: " . $this->command->config->appCssFilePath);
        $this->command->line(" Contents:");
        $this->command->newLine();
        $this->command->line($this->command->config->cssFileContents);
    }

    protected function ensureCSSFileExists(): void
    {
        if (!File::exists($this->command->config->appCssFilePath)) {
            throw new FileNotFoundException("The CSS file located at " . $this->command->config->appCssFilePath . " has not been found.");
        }
    }

    protected function saveCSSFile(): void
    {
        File::put($this->command->config->appCssFilePath, $this->command->config->cssFileContents);
    }

    public function run(): bool
    {
        try {
            $this->ensureCSSFileExists();
            $this->modifyCSSFile();
            if ($this->command->isDryRun()) {
                $this->displayDryRunCSSOutput();
            } else {
                $this->saveCSSFile();
                $this->command->info("The app.css file has been successfully modified.");
            }
            return true;
        } catch (FileNotFoundException $e) {
            $this->handleFileNotFoundException($e);
            return false;
        } catch (\Exception $e) {
            $this->handleGenericException($e, "injecting content into the CSS file");
            return false;
        }
    }
}