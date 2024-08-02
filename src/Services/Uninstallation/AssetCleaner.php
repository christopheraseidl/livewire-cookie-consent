<?php

namespace christopheraseidl\CookieConsent\Services\Uninstallation;

use christopheraseidl\CookieConsent\Exceptions\DirectoryDeletionException;
use christopheraseidl\CookieConsent\Exceptions\FileDeletionException;
use christopheraseidl\CookieConsent\Services\Common\BaseCommandService;
use Illuminate\Support\Facades\File;

class AssetCleaner extends BaseCommandService
{
    public function run(): bool
    {
        try {            
             $this->command->info("Cleaning up package assets...");

            $removals = [
                'package public directory' => fn() => $this->removeDirectory($this->command->publicDirectory),
                'vendor public directory' => fn() => $this->removeDirectoryIfEmpty(public_path($this->command->vendorDirectory)),
                'package lang directory' => fn() => $this->removeDirectory($this->command->langDirectory),
                'vendor lang directory' => fn() => $this->removeDirectoryIfEmpty(lang_path($this->command->vendorDirectory)),
                'package views directory' => fn() => $this->removeDirectory($this->command->viewsDirectory),
                'vendor views directory' => fn() => $this->removeDirectoryIfEmpty(resource_path('views/' . $this->command->vendorDirectory)),
                'default config' => fn() => $this->unlink($this->command->defaultConfig),
                'files config' => fn() => $this->unlink($this->command->filesConfig),
            ];

            foreach ($removals as $description => $operation) {
                try {
                    $operation();
                     $this->command->info("Successfully removed $description");
                } catch (\Exception $e) {
                     $this->handleGenericException($e, "removing $description");
                }
            }

            return true;
        } catch (DirectoryDeletionException $e) {
             $this->handleDirectoryDeletionException($e);
            return false;
        } catch (FileDeletionException $e) {
             $this->handleFileDeletionException($e);
            return false;
        } catch (\Exception $e) {
             $this->handleGenericException($e, "cleaning up assets");
            return false;
        }
    }

    private function removeDirectory(string $dir): void
    {
        if (!File::isDirectory($dir)) {
             $this->command->info("Directory does not exist: $dir");
            return;
        }

        if ( $this->command->isdryRun()) {
             $this->command->info("Would remove directory: $dir");
            return;
        }

        if (File::deleteDirectory($dir)) {
             $this->command->info("Removed directory: $dir");
        } else {
             $this->command->error("Failed to remove directory: $dir");
        }
    }

    private function unlink(string $file): void
    {
        if (!File::exists($file)) {
             $this->command->info("File does not exist: $file");
            return;
        }

        if ( $this->command->isdryRun()) {
             $this->command->info("Would remove file: $file");
            return;
        }

        if (File::delete($file)) {
             $this->command->info("Removed file: $file");
        } else {
            throw new FileDeletionException($file);
        }
    }

    private function removeDirectoryIfEmpty(string $dir): void
    {
        if (!File::isDirectory($dir)) {
             $this->command->info("Directory does not exist: $dir");
            return;
        }

        if (!File::isEmptyDirectory($dir)) {
             $this->command->info("Directory is not empty: $dir");
            return;
        }

        if ( $this->command->isdryRun()) {
             $this->command->info("Would remove empty directory: $dir");
            return;
        }

        if (File::deleteDirectory($dir)) {
             $this->command->info("Removed empty directory: $dir");
        } else {
            throw new DirectoryDeletionException($dir);
        }
    }

    private function handleDirectoryDeletionException(DirectoryDeletionException $e): void
    {
         $this->command->error( $this->command->dryRunPrefix() . $e->getMessage());
    }

    private function handleFileDeletionException(FileDeletionException $e): void
    {
         $this->command->error( $this->command->dryRunPrefix() . $e->getMessage());
    }
}