<?php

namespace christopheraseidl\CookieConsent\Services\Installation;

use christopheraseidl\CookieConsent\Services\Common\BaseCommandService;
use Illuminate\Support\Facades\Artisan;

class AssetPublisher extends BaseCommandService
{
    public function run(): bool
    {
        try {
            if ( $this->command->isDryRun()) {
                $this->command->info("The following commands would be run:");
                $this->command->line(" - Artisan::call('vendor:publish --tag=\"cookie-consent-images\"')");
                $this->command->line(" - Artisan::call('vendor:publish --tag=\"cookie-consent-css\"')");
            } else {
                Artisan::call('vendor:publish --tag="cookie-consent-images"');
                Artisan::call('vendor:publish --tag="cookie-consent-css"');
                $this->command->info("The assets have been published.");
            }
            return true;
        } catch (\Exception $e) {
            $this->handleGenericException($e, "publishing the assets");
            return false;
        }
    }
}