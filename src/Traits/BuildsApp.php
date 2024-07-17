<?php

namespace christopheraseidl\CookieConsent\Traits;

trait BuildsApp {
    /**
     * Execute the 'npm run build' command.
     */
    private function build(): void
    {
        // Check if the 'build' script exists
        $scripts = shell_exec("npm run");

        if (strpos($scripts, 'build') === false) {
            $this->error("The 'build' script is not defined in package.json. You may need to install Vite by running 'npm install vite'.");
            return;
        }

        $output = null;
        $status = null;

        exec("npm run build", $output, $status);

        // Output the result
        foreach ($output as $line) {
            $this->info($line);
        }

        if ($status !== 0) {
            $this->error("'npm run build' failed with status code $status.");
        }
    }
}