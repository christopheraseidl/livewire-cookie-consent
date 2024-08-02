<?php

namespace christopheraseidl\CookieConsent\Services\Common;

use christopheraseidl\CookieConsent\Commands\BaseCommand;
use christopheraseidl\CookieConsent\Exceptions\FileNotFoundException;
use Illuminate\Support\Facades\File;

abstract class BaseCommandService
{
    /**
     * @var BaseCommand The instance of the BaseCommand class.
     */
    protected BaseCommand $command;

    /**
     * Run the service.
     */
    abstract public function run(): bool;

    public function __construct(BaseCommand $command) {
        $this->command = $command;
    }

    protected function handleFileNotFoundException(FileNotFoundException $e): void
    {
        $this->command->error($this->command->dryRunPrefix() . $e->getMessage());
    }

    protected function handleGenericException(\Exception $e, string $doing): void
    {
        $this->command->error($this->command->dryRunPrefix() . "An error occurred while $doing: {$e->getMessage()}");
    }

    protected function indent(int $count = 1)
    {
        return str_repeat($this->command->config->indent, $count);
    }
    
    protected function lineExists($haystack, $needle): bool
    {
        return strpos($haystack, $needle) !== false;
    }

    protected function saveFile(string $path, string $contents): void
    {
        File::put($path, $contents);
    }

    protected function trimTrailingWhitespaceAndComma(string $string): string
    {
        $string = trim($string);
        return rtrim($string, ", \t\n\r\0\x0B");
    }
}