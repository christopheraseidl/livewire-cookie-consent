# Add a GDPR-compliant cookie notice to your Laravel project using Livewire

This package provides an easy way to display a cookie consent notice along with a cookie policy that can be displayed in the default modal or anywhere else in your application. It requires Livewire 3 and Tailwind CSS.

All websites that wish to be used in Europe must comply with an EU law stipulating that users must be advised of &mdash; and must consent to &mdash; any tracking or analytics cookies. Functional cookies are optional. To be sure, you may want to consult the [European Commission guidelines](https://commission.europa.eu/resources-partners/europa-web-guide/design-content-and-development/privacy-security-and-legal-notices/cookies-and-similar-technologies_en).

When using this package, be sure to confirm that the policy text meets your requirements. You will probably want to edit it after publishing the views.

Finally, note that this package ships by default with English and Spanish translations.

## Installation

You can install the package via composer:

```bash
composer require christopheraseidl/livewire-cookie-consent
```

You should then run the installation command:

```bash
php artisan cookie-consent:install
```

This will:

1. publish the necessary assets;
2. set up `tailwind.config.js`, `vite.config.js`, and `app.css`;
3. and run `npm run build` to compile your project for production.

The package will automatically register its service provider.

If you are using an alternative asset bundler like Mix, you will need to make some manual adjustments to the installation and setup process.

If you publish the views, you should modify your `tailwind.config.js` file to exclude the defaults located in the `/vendor/christopheraseidl/livewire-cookie-consent` folder.

## Configuration

You may publish the config file if you wish:

```bash
php artisan vendor:publish --provider="christopheraseidl\CookieConsent\CookieConsentServiceProvider" --tag="cookie-consent-config"
```

By default, the contents of this file are as follows:

```php
return [
    'cookie_name'             => 'cas_laravel_cookie_consent',
    'cookies_to_delete'       => [],
    'consent_value'           => 'yes',
    'refuse_value'            => 'no',
    'enabled'                 => true,
    'consent_cookie_lifetime' => 60 * 24 * 365,
    'refuse_cookie_lifetime'  => 60 * 24 * 30,
    'available_locales'       => ['en', 'es'],
];
```

## Usage

You have two options for using the modal that asks the user for consent:

#### Option 1. Including the Livewire component directly in a template:

```blade
// Somewhere in your blade template
@livewire('cookie-consent')
```

#### Option 2. Adding the middleware to the kernel:

```php
// app/Http/Kernel.php

class Kernel extends HttpKernel
{
    protected $middleware = [
        // ...
        \christopheraseidl\CookieConsent\CookieConsentMiddleware::class,
    ];

    // ...
}
```

When the user allows cookies &mdash; by clicking `Yes.` &mdash; a `cas_laravel_cookie_consent` cookie will be set, and the dialog will be hidden until the cookie expires, by default with a lifetime of `60 * 24 * 365`.

You can check whether consent has been given with the provided service facade: `CookieConsent::consentGiven()`.

You can call a similar method to check whether consent has been refused: `CookieConsent::consentRefused()`.

## Including the cookie policy component

The modal provided by this package already includes the cookie policy component, which you can include anywhere in your application, like so:

```php
<x-cookie-policy />
```

You may customize this policy by publishing the views and editing the resulting component view file.

Should you wish to provide a policy in another language, first [set up your application to use your locale](https://laravel.com/docs/11.x/localization), then create a directory for your locale in `/resources/views/christopheraseidl/policy/`, then place a file there called `cookie-policy.blade.php`

## Disabling the package

To stop this package from displaying a modal or handling cookie consent, after publishing the configuration file, change `enabled` to `false`.

## Deleting an array of cookies when consent is refused

If you want to delete cookies in your application when the user refuses consent, publish the config file and add their names to the `cookies_to_delete` array. For example:

```php
//config/cookie-consent.php

return [
    // ...
    'cookies_to_delete' => ['delete_me', 'delete_me_also'],
];
```

## Customizing translations

You may publish the translations to `resources/lang/christopheraseidl/cookie-consent` with this command:

```bash
php artisan vendor:publish --provider="christopheraseidl\CookieConsent\CookieConsentServiceProvider" --tag="cookie-consent-translations"
```

## Customizing views

You may publish the views to `resources/views/christopheraseidl/cookie-consent` with this command:

```bash
php artisan vendor:publish --provider="christopheraseidl\CookieConsent\CookieConsentServiceProvider" --tag="cookie-consent-views"
```

## Uninstalling

Before running `composer remove christopheraseidl/livewire-cookie-consent`, you should run the following command to clean up after this package:

```bash
php artisan cookie-consent:uninstall
```

## Testing

``` bash
vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.