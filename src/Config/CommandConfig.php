<?php

namespace christopheraseidl\CookieConsent\Config;

use christopheraseidl\CookieConsent\Interfaces\CommandConfigInterface;
use Illuminate\Support\Facades\File;

class CommandConfig extends BaseConfiguration implements CommandConfigInterface
{
    public function __construct(array $properties = [])
    {
        parent::__construct($properties);

        $this->setDefaults();
    }

    protected function setDefaults(): void
    {
        foreach ($this->getCommandConfigDefaults() as $key => $value) {
            if (!isset($this->properties[$key])) {
                $this->properties[$key] = $value;
            }
        }
    }

    protected function getCommandConfigDefaults(): array
    {
        return [
            // The path of the app.css file.
            'app_css_file_path' => resource_path(
                config('cookie-consent-files.app_css_file_path', 'css/app.css')
            ),
        
            // The contents of app.css.
            'css_file_contents' => File::exists(resource_path(
                config('cookie-consent-files.app_css_file_path', 'css/app.css')
            )) ? File::get(resource_path(
                config('cookie-consent-files.app_css_file_path', 'css/app.css')
            )) : '',
        
            // The line to be added at the top of app.css.
            'css_line' => config(
                'cookie-consent-files.css_line',
                '@import url(\'/resources/css/christopheraseidl/cookie-consent/cookie-consent.css\');'
            ),
        
            // The name of the default configuration file.
            'default_config' => base_path(
                config('cookie-consent-files.default_config', 'config/cookie-consent.php')
            ),
        
            // The name of the files configuration file.
            'files_config' => base_path(
                config('cookie-consent-files.files_config', 'config/cookie-consent-files.php')
            ),
        
            // The indentation used for inserting new lines into files.
            'indent' => config('cookie-consent-files.indent', '    '),
        
            // The package translations directory.
            'lang_directory' => lang_path(
                config('cookie-consent-files.lang_directory', 'christopheraseidl/cookie-consent')
            ),
        
            // The package CSS directory.
            'package_css_directory' => resource_path(
                config('cookie-consent-files.package_css_directory', 'css/christopheraseidl/cookie-consent')
            ),
        
            // The package public directory.
            'public_directory' => public_path(
                config('cookie-consent-files.public_directory', 'christopheraseidl/cookie-consent')
            ),
        
            // The contents of tailwind.config.js.
            'tailwind_config_file_contents' => File::exists(base_path(
                config('cookie-consent-files.tailwind_config_file_path', 'tailwind.config.js')
            )) ? File::get(base_path(
                config('cookie-consent-files.tailwind_config_file_path', 'tailwind.config.js')
            )) : '',
        
            // The path of tailwind.config.js.
            'tailwind_config_file_path' => base_path(
                config('cookie-consent-files.tailwind_config_file_path', 'tailwind.config.js')
            ),
        
            // The line to be added to tailwind.config.js.
            'tailwind_line' => config(
                'cookie-consent-files.tailwind_line',
                '"./vendor/christopheraseidl/**/*.blade.php"'
            ),
        
            // The regex pattern used to search for the content to modify in tailwind.config.js.
            'tailwind_pattern' => config(
                'cookie-consent-files.tailwind_pattern', '/content:\s*\[([^\]]*)\]/'
            ),
        
            // The vendor CSS directory.
            'vendor_css_directory' => resource_path(
                config('cookie-consent-files.vendor_css_directory', 'css/christopheraseidl')
            ),
        
            // The package vendor directory name to be used for published assets.
            'vendor_directory' => config(
                'cookie-consent-files.vendor_directory', 'christopheraseidl'
            ),
        
            // The package views directory.
            'views_directory' => resource_path(
                config('cookie-consent-files.views_directory', 'views/christopheraseidl/cookie-consent')
            ),
        
            // The contents of vite.config.js.
            'vite_config_file_contents' => File::exists(base_path(
                config('cookie-consent-files.vite_config_file_path', 'vite.config.js')
            )) ? File::get(base_path(
                config('cookie-consent-files.vite_config_file_path', 'vite.config.js')
            )) : '',
        
            // The path of vite.config.js.
            'vite_config_file_path' => base_path(
                config('cookie-consent-files.vite_config_file_path', 'vite.config.js')
            ),
        
            // The line to be added to vite.config.js.
            'vite_line' => config(
                'cookie-consent-files.vite_line',
                '\'resources/css/christopheraseidl/cookie-consent/cookie-consent.css\''
            ),
        
            // The regex pattern used to search for the content to modify in vite.config.js.
            'vite_pattern' => config(
                'cookie-consent-files.vite_pattern', '/input:\s*\[([^\]]*)\]/'
            ),
        ];
    }
}