# Spammers for Laravel 5.4+

Simple package to prevent accessing of spammers to Laravel application.

![spammers](https://user-images.githubusercontent.com/10347617/33530091-1cba8f1a-d88b-11e7-8d1d-eb7a924199d2.png)

# -= Coming Soon =-
This code was written without testing and without running on a production project. Therefore, it can contain errors and does not work at all. Temporarily :)

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

Next, call `php artisan vendor:publish` command.

Now, use `spammer()` helper.


## Documentation

* [Helpers](#helpers)
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


#### Console Command

This package maybe called in a console:

    spam:store
    spam:delete
    spam:restore
    spam:exists


## Support Package

You can donate via [Yandex Money](https://money.yandex.ru/quickpay/shop-widget?account=410012608840929&quickpay=shop&payment-type-choice=on&mobile-payment-type-choice=on&writer=seller&targets=Andrey+Helldar%3A+Open+Source+Projects&targets-hint=&default-sum=&button-text=04&mail=on&successURL=), WebMoney (Z124862854284, R343524258966).

## Copyright and License

Laravel Spammers was written by Andrey Helldar for the Laravel framework 5.4 or later, and is released under the MIT License. See the [LICENSE](LICENSE) file for details.

## Translation

Translations of text and comment by Google Translate. Help with translation +1 in karma :)
