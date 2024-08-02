<?php

namespace christopheraseidl\CookieConsent\Commands;

use christopheraseidl\CookieConsent\Interfaces\CommandConfigInterface;
use christopheraseidl\CookieConsent\Services\Common\NPMBuildHandler;
use christopheraseidl\CookieConsent\Services\Uninstallation\AssetCleaner;
use christopheraseidl\CookieConsent\Services\Uninstallation\CSSFileCleaner;
use christopheraseidl\CookieConsent\Services\Uninstallation\TailwindConfigCleaner;
use christopheraseidl\CookieConsent\Services\Uninstallation\ViteConfigCleaner;

/**
 * Uninstall the Livewire Cookie Consent package.
 */
class UninstallCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cookie-consent:uninstall {--dry-run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall the Livewire Cookie Consent package.';

    public function __construct(CommandConfigInterface $config)
    {
        parent::__construct($config);

        // Define the services to run in the handle() method.
        $this->services = [
            AssetCleaner::class,
            CSSFileCleaner::class,
            TailwindConfigCleaner::class,
            ViteConfigCleaner::class,
            NPMBuildHandler::class,
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->displayInitialOutput();

        $this->runServices();

        $this->displayFinalOutput();
    }

    private function displayInitialOutput(): void
    {
        if ($this->option('dry-run')) {
            $this->info("Dry run mode activated. No changes will be made.");
        } else {
            $this->info("Livewire Cookie Consent is uninstalling...");
        }
    }

    private function displayFinalOutput(): void
    {
        $this->info("Livewire Cookie Consent uninstallation is complete.");
    }
}