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

To use the library, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

    require_once('vendor/autoload.php');

## Getting Started

Usage example:

    $mobiniti = \Mobiniti\Api\Client('your_access_token');
    $contact = $mobiniti->contacts()->create(['phone_number' => 5555555555]);

## Available objects
### Campaigns
    $mobiniti = \Mobiniti\Api\Client('your_access_token');
    $mobiniti->campaigns()
    
### Contacts
    $mobiniti = \Mobiniti\Api\Client('your_access_token');
    $mobiniti->contacts()
### Coupons
    $mobiniti = \Mobiniti\Api\Client('your_access_token');
    $mobiniti->coupons()
### Groups
     $mobiniti = \Mobiniti\Api\Client('your_access_token');
     $mobiniti->groups()
### Messages
    $mobiniti = \Mobiniti\Api\Client('your_access_token');
    $mobiniti->messages()

### Object methods
All of the above objects have the following methods

* all($limit, $page)
* retrieve($id)
* create([])
* update($id, [])
* delete($id) - **Only available on contacts and campaigns**

## Documentation

Please see [autoload](https://api.mobiniti.com/docs) for complete API documentation.
