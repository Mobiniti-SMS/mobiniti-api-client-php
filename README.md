You can sign up for a Mobiniti account at https://app.mobiniti.com.

## Requirements

PHP 5.4 and later.

## Composer

You can install the library via [Composer](http://getcomposer.org/). Add this to your `composer.json`:

    {
      "require": {
        "greyght/mobiniti-php": "1.*"
      }
    }

Then install via:

    composer install

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

    require_once('vendor/autoload.php');

## Getting Started

Usage example:

    $mobiniti = \Mobiniti\Api\Client('your_access_token');
    $contact = $mobiniti->contacts()->create(['phone_number' => 5555555555]);

## Documentation

Please see https://api.mobiniti.com/docs for up-to-date documentation.
