<?php

namespace christopheraseidl\CookieConsent\Config;

use christopheraseidl\CookieConsent\Interfaces\AssetConfigInterface;

class AssetConfig extends BaseConfiguration implements AssetConfigInterface
{
    
    public function __construct(array $properties = [])
    {
        parent::__construct($properties);

        $this->setDefaults();
    }

    protected function setDefaults(): void
    {
        foreach ($this->getAssetPublishingConfigDefaults() as $key => $value) {
            if (!isset($this->properties[$key])) {
                $this->properties[$key] = $value;
            }
        }
    }

    protected function getAssetPublishingConfigDefaults(): array
    {
        return [
            // The CSS publishing path.
            'css_path' => resource_path('css/christopheraseidl/cookie-consent'),

            // The default config publishing path.
            'default_config_path' => config_path('cookie-consent.php'),

            // The files config publishing path.
            'files_config_path' => config_path('cookie-consent-files.php'),

            // The images publishing path.
            'images_path' => public_path('christopheraseidl/cookie-consent/images'),

            // The translations publishing path.
            'translations_path' => lang_path('christopheraseidl/cookie-consent'),

            // The views publishing path.
            'views_path' => resource_path('views/christopheraseidl/cookie-consent')
        ];
    }
}