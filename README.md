Pushy SDK
=============
A PHP package to access the Pushy API by a comprehensive way.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

With Composer installed, you can then install the extension using the following commands:

```bash
$ php composer.phar require jlorente/pushy-php-sdk
```

or add 

```json
...
    "require": {
        "jlorente/pushy-php-sdk": "*"
    }
```

to the ```require``` section of your `composer.json` file.

## Configuration

You can set the SECRET_API_KEY as environment variables or add them later 
on Pushy class instantiation.

The name of the environment var is PUSHY_SECRET_API_KEY.

## Usage

Endpoints calls must done through the Pushy class.

If you haven't set the environment variable previously, remember to provide the 
key on instantiation.

```php
$pushy = new \Jlorente\Pushy\Pushy($secretApiKey);
$pushy->api()->deviceInfo($token);
```

## License 
Copyright &copy; 2019 José Lorente Martín <jose.lorente.martin@gmail.com>.

Licensed under the BSD 3-Clause License. See LICENSE.txt for details.
