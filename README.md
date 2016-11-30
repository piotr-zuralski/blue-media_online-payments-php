# Płatności Online BM

Biblioteka integracyjna do systemu Płatności online BM

## Wymagania

1. PHP od wersji 5.5
2. Wymagane rozszeżenia:
    - xmlwriter
    - xmlreader
    - iconv
    - mbstring
    - hash
3. Rozszeżenie cURL jest zalecane ale nie wymagane.

## Instalacja

### Composer

The recommended way to install is through
[Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer in root dir of "Blue Media online payments" command to install required vendors:

```bash
composer.phar install
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

You can then later update "Blue Media online payments" using composer:

 ```bash
composer.phar update
 ```

Documentation
-------------

For usage see examples dir.
