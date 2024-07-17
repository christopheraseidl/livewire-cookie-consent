<?php

namespace christopheraseidl\CookieConsent\Commands;

use christopheraseidl\CookieConsent\Traits\BuildsApp;
use Illuminate\Console\Command;

class UninstallCommand extends Command
{
    use BuildsApp;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cookie-consent:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall the Livewire Cookie Consent package.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->removeLineFromTailwindConfig();

        $this->removeLineFromViteConfig();

        $this->removeLineFromAppCSS();

        $this->removeAssets();

        $this->build();

        $this->info('Livewire Cookie Consent successfully uninstalled.');
    }

    private function removeLineFromTailwindConfig(): void
    {
        $tailwindConfigPath = base_path('tailwind.config.js');
        $tailwindConfig = file_get_contents($tailwindConfigPath);

        $lineToRemove = '"./vendor/christopheraseidl/**/*.blade.php"';
        $pattern = '/content:\s*\[([^\]]*)\]/';

        $replacement = preg_replace_callback($pattern, function ($matches) use ($lineToRemove) {
            // Check if the line doesn't exist
            if (strpos($matches[1], $lineToRemove) === false) {
                return $matches[0];
            }

            $content = $this->trim($matches[1], $lineToRemove);

            // Return our modified content
            return "content: [\n        {$content}]";
        }, $tailwindConfig);

        file_put_contents($tailwindConfigPath, $replacement);
    }

    private function removeLineFromViteConfig(): void
    {
        $viteConfigPath = base_path('vite.config.js');
        $viteConfig = file_get_contents($viteConfigPath);

        $lineToRemove = "'public/christopheraseidl/cookie-consent/css/cookie-consent.css'";
        $pattern = '/input:\s*\[([^\]]*)\]/';

        $replacement = preg_replace_callback($pattern, function ($matches) use ($lineToRemove) {
            // Check if the line doesn't exist
            if (strpos($matches[1], $lineToRemove) === false) {
                return $matches[0];
            }

            $content = $this->trim($matches[1], $lineToRemove);

            return "input: [{$content}]";
        }, $viteConfig);

        file_put_contents($viteConfigPath, $replacement);
    }

    private function removeLineFromAppCSS(): void
    {
        $cssPath = resource_path('css/app.css');

        if (! file_exists($cssPath)) {
            return;
        }

        $css = file_get_contents($cssPath);
        $lineToRemove = "@import url('/public/christopheraseidl/cookie-consent/css/cookie-consent.css');";

        $css = str_replace($lineToRemove, '', $css);

        $css = trim($css);

        file_put_contents($cssPath, $css);
    }

    private function trim(string $haystack, ?string $needle): ?string
    {
        // Remove the $needle
        $content = str_replace($needle, '', $haystack);

        // Remove first possible trailing comma
        $content = rtrim($content, ',');

        // Remove trailing spaces
        $content = trim($content);

        // Remove second possible trailing comma
        return rtrim($content, ',');
    }

    private function removeAssets(): void
    {
        // Delete public directory
        $this->removeDirectory(public_path('christopheraseidl/cookie-consent'));

        // Delete published translations.
        $this->removeDirectory(lang_path('christopheraseidl/cookie-consent'));

        // Remove the vendor languages directory if it's empty
        $this->removeDirectoryIfEmpty(lang_path('christopheraseidl'));

        // Delete published views.
        $this->removeDirectory(base_path('resources/views/christopheraseidl/cookie-consent'));

        // Remove the vendor views directory if it's empty
        $this->removeDirectoryIfEmpty(resource_path('views/christopheraseidl'));

        // Delete published config.
        $this->unlink(base_path('config/cookie-consent.php'));

        // Remove the vendor public directory if it's empty
        $this->removeDirectoryIfEmpty(public_path('christopheraseidl'));
    }

    private function removeDirectory(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }

        // Iterate through files and subdirectories
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $filePath = "$dir/$file";
            if (is_dir($filePath)) {
                // Recursively delete subdirectory
                $this->removeDirectory($filePath);
            } else {
                // Delete file
                unlink($filePath);
            }
        }

        // Remove the empty directory
        rmdir($dir);
    }

    private function unlink(string $file): void
    {
        if (! file_exists($file)) {
            return;
        }

        unlink($file);
    }

    private function removeDirectoryIfEmpty(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }

        $handle = opendir($dir);

        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                closedir($handle);
                return;
            }
        }

        closedir($handle);

        $this->removeDirectory($dir);
    }
}