<?php

namespace christopheraseidl\CookieConsent\Commands;

use christopheraseidl\CookieConsent\Exceptions\RunMethodDoesNotExistException;
use christopheraseidl\CookieConsent\Interfaces\CommandConfigInterface;
use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{
    /**
     * @var Configuration The object that holds configuration properties.
     */
    public CommandConfigInterface $config;

    /**
     * @var array The array that holds the service classes to execute in the handle() method.
     */
    public array $services;

    public function __construct(CommandConfigInterface $config)
    {
        parent::__construct();
        $this->config = $config;
    }

    protected function runServices(): bool
    {
        try {
            foreach ($this->services as $serviceClass) {
                $this->ensureRunMethodExistsOnService($serviceClass);
                $service = app($serviceClass, ['command' => $this]);
                $service->run();
            }
            return true;
        } catch (RunMethodDoesNotExistException $e) {
            $this->handleRunMethodDoesNotExistException($e);
            return false;
        } catch (\Exception $e) {
            $this->error("An error occurred while running services: {$e->getMessage()}");
            return false;
        }
        
    }

    private function ensureRunMethodExistsOnService(string $service): void
    {
        if (!method_exists($service, 'run')) {
            throw new RunMethodDoesNotExistException("The 'run' method does not exist in $service.");
        }
    }

    private function handleRunMethodDoesNotExistException(RunMethodDoesNotExistException $e): void
    {
        $this->error($this->dryRunPrefix() . $e->getMessage());
    }

    /**
     * Use this method to add a prefix to console output when the --dry-run option is present.
     */
    public function dryRunPrefix(): string
    {
        return $this->option('dry-run') ? "[Dry run] " : "";
    }

    public function isDryRun(): bool
    {
        return $this->option('dry-run');
    }
}