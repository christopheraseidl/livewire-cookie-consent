<?php

namespace christopheraseidl\CookieConsent\Commands;

use christopheraseidl\CookieConsent\Traits\BuildsApp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    use BuildsApp;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cookie-consent:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Livewire Cookie Consent package';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->addLineToTailwindConfig();

        $this->addLineToViteConfig();

        $this->addLineToAppCSS();

        $this->publishAssets();

        $this->build();

        $this->info('Livewire Cookie Consent successfully installed!');
    }

    private function addLineToTailwindConfig(): void
    {
        $tailwindConfigPath = base_path('tailwind.config.js');
        $tailwindConfig = file_get_contents($tailwindConfigPath);

        $newLine = '"./vendor/christopheraseidl/**/*.blade.php"';
        $pattern = '/content:\s*\[([^\]]*)\]/';

        $replacement = preg_replace_callback($pattern, function ($matches) use ($newLine) {
            // Check if the new line already exists
            if (strpos($matches[1], $newLine) !== false) {
                return $matches[0];
            }

            // Remove trailing spaces
            $trimmedMatches = trim($matches[1]);

            // Remove trailing comma
            $trimmedMatches = rtrim($trimmedMatches, ',');

            // Add our new line
            return "content: [\n        {$trimmedMatches},\n        {$newLine}\n    ]";
        }, $tailwindConfig);

        file_put_contents($tailwindConfigPath, $replacement);
    }

    private function addLineToViteConfig(): void
    {
        $viteConfigPath = base_path('vite.config.js');
        $viteConfig = file_get_contents($viteConfigPath);

        $newLine = "'public/christopheraseidl/cookie-consent/css/cookie-consent.css'";
        $pattern = '/input:\s*\[([^\]]*)\]/';

        $replacement = preg_replace_callback($pattern, function ($matches) use ($newLine) {
            // Check if the new line already exists
            if (strpos($matches[1], $newLine) !== false) {
                return $matches[0];
            }

            // Remove trailing spaces
            $trimmedMatches = trim($matches[1]);

            // Remove trailing comma
            $trimmedMatches = rtrim($trimmedMatches, ',');

            return "input: [{$trimmedMatches}, {$newLine}]";
        }, $viteConfig);

        file_put_contents($viteConfigPath, $replacement);
    }

    private function addLineToAppCSS(): void
    {
        $cssPath = resource_path('css/app.css');

        if (! file_exists($cssPath)) {
            return;
        }

        $css = file_get_contents($cssPath);
        $newLine = "@import url('/public/christopheraseidl/cookie-consent/css/cookie-consent.css');";

        if (str_contains($css, $newLine)) {
            return;
        }

        $css = $newLine . "\n\n" . $css;
        file_put_contents($cssPath, $css);
    }

    private function publishAssets(): void
    {
        Artisan::call('vendor:publish --tag="cookie-consent-images"');
        Artisan::call('vendor:publish --tag="cookie-consent-css"');
    }
}