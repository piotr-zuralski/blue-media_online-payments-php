# [Blue Media Online Payments System](https://platnosci.bm.pl/)

Integration library for the BM (Blue Media) Online Payments System

## Requirements

1. PHP from version 5.5
2. Required extensions:
    - xmlwriter
    - xmlreader
    - iconv
    - mbstring
    - hash
3. The cURL extension is recommended but not required.

## Installation

### Composer

The recommended way to install via [Composer](http://getcomposer.org).

1. [Install Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
2. To install "Blue Media Online Payments System" with dependencies, run Composer in the main "Blue Media Online Payments System" directory:

```bash
composer install
```

or if you want to add "Blue Media Online Payments System" to your project, just run:

```bash
composer require blue-media/online-payments-php
```

3. After installation, the Composer autoloader must be loaded in the project:

```php
require 'vendor/autoload.php';
```

You can then update "Blue Media Online Payments System" using Composer:

```bash
composer update blue-media/online-payments-php
```

## Documentation

For latest documentation, specifications or question please contact [Blue Media](mailto:info@bm.pl)

1. Information page [Online Payments BM](https://platnosci.bm.pl/)
2. [Examples of use](https://gitlab.com/blue-media/online-payments-php/tree/master/examples)
3. [Specification](https://gitlab.com/blue-media/online-payments-php/tree/master/docs/)
4. [Administrative panel - production](https://oplacasie.bm.pl/)
5. [Administrative panel - testing](https://oplacasie-accept.bm.pl/)
