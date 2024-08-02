<?php

namespace christopheraseidl\CookieConsent\Commands;

use christopheraseidl\CookieConsent\Interfaces\CommandConfigInterface;
use christopheraseidl\CookieConsent\Services\Common\NPMBuildHandler;
use christopheraseidl\CookieConsent\Services\Installation\AssetPublisher;
use christopheraseidl\CookieConsent\Services\Installation\CSSFileInjector;
use christopheraseidl\CookieConsent\Services\Installation\TailwindConfigInjector;
use christopheraseidl\CookieConsent\Services\Installation\ViteConfigInjector;

/**
 * Install the Livewire Cookie Consent package.
 */
class InstallCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cookie-consent:install {--dry-run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Livewire Cookie Consent package';

    public function __construct(CommandConfigInterface $config)
    {
        parent::__construct($config);

        // Define the services to run in the handle() method.
        $this->services = [
            AssetPublisher::class,
            CSSFileInjector::class,
            TailwindConfigInjector::class,
            ViteConfigInjector::class,
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
            $this->info("Livewire Cookie Consent is installing...");
        }
    }

    private function displayFinalOutput(): void
    {
        $this->info("Livewire Cookie Consent installation is complete!");
    }
}