<?php

namespace christopheraseidl\CookieConsent\Services\Common;

use christopheraseidl\CookieConsent\Commands\BaseCommand;
use christopheraseidl\CookieConsent\Exceptions\NPMRunBuildFailedException;
use christopheraseidl\CookieConsent\Exceptions\NPMRunBuildNotFoundException;
use christopheraseidl\CookieConsent\Services\Common\BaseCommandService;

/**
 * Execute the 'npm run build' command if it is available.
 */
class NPMBuildHandler extends BaseCommandService
{
    public function run(): bool
    {
        try {
            $this->ensureBuildExists();

            if ($this->command->isDryRun()) {
                $this->displayBuildDryRunOutput();
            } else {
                $this->command->info("Executing 'npm run build'...");
                list($output, $status) = $this->executeBuild();
                $this->ensureBuildSuccess($status);
                $this->displayBuildOutput($output);
            }
            return true;
        } catch (NPMRunBuildNotFoundException $e) {
            $this->handleNPMRunBuildNotFoundException($e);
            return false;
        } catch (NPMRunBuildFailedException $e) {
            $this->handleNPMRunBuildFailedException($e);
            return false;
        } catch (\Exception $e) {
            $this->handleGenericException($e, "running 'npm run build'");
            return false;
        }
    }

    private function ensureBuildExists(): void
    {
        if (!$this->buildExists()) {
            throw new NPMRunBuildNotFoundException("The 'build' script is not defined in package.json. You may need to install Vite by running 'npm install vite'.");
        }
    }

    private function displayBuildDryRunOutput(): void
    {
        $this->command->info("The 'npm run build' command would be run.");
    }

    private function buildExists(): bool
    {
        $scripts = shell_exec("npm run");

        return strpos($scripts, 'build') !== false;
    }

    private function executeBuild(): array
    {
        $output = null;
        $status = null;

        exec("npm run build", $output, $status);

        return [$output, $status];
    }

    private function ensureBuildSuccess(int $status): void
    {
        if ($status !== 0) {
            throw new NPMRunBuildFailedException("'npm run build' failed with status code $status.");
        }
    }

    private function displayBuildOutput(array $output): void
    {
        foreach ($output as $line) {
            $this->command->line($line);
        }
    }

    private function handleNPMRunBuildNotFoundException(NPMRunBuildNotFoundException $e): void
    {
        $this->command->error($this->command->dryRunPrefix() . $e->getMessage());
    }

    private function handleNPMRunBuildFailedException(NPMRunBuildFailedException $e): void
    {
        $this->command->error($this->command->dryRunPrefix() . $e->getMessage());
    }
}