#!/usr/bin/env bash

set -e

PHP_VERSION_REQUIRED='5.3.0';

printf 'PHP version: ';
echo $(php -v);
printf '\n';

echo $(php -m);
printf '\n';

if [[ `php -r "version_compare(phpversion(), '${PHP_VERSION_REQUIRED}', '>=');"` ]]; then
    printf 'PHP verion under "%s", phpverion: "%s"' ${PHP_VERSION_REQUIRED} $(php -r 'echo phpversion();');
    exit 1;
fi

HAS_PHP_OPENSSL=`php -r "echo (int)extension_loaded('openssl');"`
if [[ ${HAS_PHP_OPENSSL} == 0 ]]; then
    docker-php-ext-install openssl;
fi

php_user_ini_path=`php -r "echo ini_get('user_ini.filename');"`
php_ini_path=`php -i | grep -i 'Loaded Configuration File => ' | sed -e 's/Loaded Configuration File => //g' `;

echo "" > ${php_user_ini_path};
echo "memory_limit = -1" >> ${php_user_ini_path};
echo "date.timezone = UTC" >> ${php_user_ini_path};
