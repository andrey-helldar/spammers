# Spammers for Laravel 5.4+

Simple package to prevent accessing of spammers to Laravel application.

![spammers](https://user-images.githubusercontent.com/10347617/33530091-1cba8f1a-d88b-11e7-8d1d-eb7a924199d2.png)

<p align="center">
<a href="https://travis-ci.org/andrey-helldar/spammers"><img src="https://travis-ci.org/andrey-helldar/spammers.svg?branch=master&style=flat-square" alt="Build Status" /></a>
<a href="https://packagist.org/packages/andrey-helldar/spammers"><img src="https://img.shields.io/packagist/dt/andrey-helldar/spammers.svg?style=flat-square" alt="Total Downloads" /></a>
<a href="https://packagist.org/packages/andrey-helldar/spammers"><img src="https://poser.pugx.org/andrey-helldar/spammers/v/stable?format=flat-square" alt="Latest Stable Version" /></a>
<a href="https://packagist.org/packages/andrey-helldar/spammers"><img src="https://poser.pugx.org/andrey-helldar/spammers/v/unstable?format=flat-square" alt="Latest Unstable Version" /></a>
<a href="https://github.com/andrey-helldar/spammers"><img src="https://poser.pugx.org/andrey-helldar/spammers/license?format=flat-square" alt="License" /></a>
</p>


<p align="center">
<a href="https://github.com/andrey-helldar/spammers"><img src="https://img.shields.io/scrutinizer/g/andrey-helldar/spammers.svg?style=flat-square" alt="Quality Score" /></a>
<a href="https://styleci.io/repos/112966311"><img src="https://styleci.io/repos/112966311/shield" alt="StyleCI" /></a>
<a href="https://php-eye.com/package/andrey-helldar/spammers"><img src="https://php-eye.com/badge/andrey-helldar/spammers/tested.svg?style=flat" alt="PHP-Eye" /></a>
</p>

## Installation

To get the latest version of this package, simply require the project using [Composer](https://getcomposer.org/):

```bash
$ composer require andrey-helldar/spammers
```

Instead, you may of course manually update your require block and run `composer update` if you so choose:

```json
{
    "require": {
        "andrey-helldar/spammers": "^1.0"
    }
}
```

If you don't use auto-discovery, add the ServiceProvider to the providers array in `config/app.php`:

    Helldar\Spammers\ServiceProvider::class,

Next, call `php artisan vendor:publish` and `php artisan migrate` commands after set up file [spammers.php](src/config/spammers.php).

Now, use `spammer()` helper and Artisan commands.


## Documentation

* [Helpers](#helpers)
* [Middleware](#middleware)
* [Console Command](#console-command)


#### Helpers

Store IP-address in a spam-table:

    spammer('1.2.3.4')->store();


Delete IP-address from a spam-table:

    spammer('1.2.3.4')->delete();


Restore IP-address from a spam-table:

    spammer('1.2.3.4')->restore();


Check exists IP-address in a spam-table:

    spammer('1.2.3.4')->exists();

Set up a schedule to exclude IP addresses that have expired from the spam table. To do this, add the following rules in the `schedule()` method of the `Console/Kernel.php` file:

```php
$schedule->command('spam:scan')
    ->hourly();
```


##### Middleware

Next, add link to middleware in `$routeMiddleware` block in `app/Http/Kernel.php` file, and use him in `$middlewareGroups` blocks:

```php
protected $middlewareGroups = [
    'web' => [
        // ...
        'spammers'
    ],

    'api' => [
        // ...
        'spammers'
    ],
];

protected $routeMiddleware = [
    // ...
    'spammers' => Helldar\Spammers\Middleware\Spammers::class
];
```


#### Console Command

This package maybe called in a console:

    spam:store 1.2.3.4
    spam:delete 1.2.3.4
    spam:restore 1.2.3.4
    spam:exists 1.2.3.4
    spam:scan

The `spam:scan` command allows you to delete IP-addresses that have expired.

## Support Package

You can donate via [Yandex Money](https://money.yandex.ru/quickpay/shop-widget?account=410012608840929&quickpay=shop&payment-type-choice=on&mobile-payment-type-choice=on&writer=seller&targets=Andrey+Helldar%3A+Open+Source+Projects&targets-hint=&default-sum=&button-text=04&mail=on&successURL=), WebMoney (Z124862854284, R343524258966).

## Copyright and License

Laravel Spammers was written by Andrey Helldar for the Laravel framework 5.4 or later, and is released under the MIT License. See the [LICENSE](LICENSE) file for details.

## Translation

Translations of text and comment by Google Translate. Help with translation +1 in karma :)
