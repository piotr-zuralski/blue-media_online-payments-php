#!/usr/bin/env bash

set -e

PHP_VERSION_REQUIRED='5.3.0';

php -v;

if [[ `php -r "version_compare(phpversion(), '${PHP_VERSION_REQUIRED}', '>=');"` ]]; then
    echo "PHP verion under ${PHP_VERSION_REQUIRED}, phpverion: $(php -r 'echo phpversion();')" ;
    exit 1;
fi

php_user_ini_path=`php -r "echo ini_get('user_ini.filename');"`
php_ini_path=`php -i | grep -i 'Loaded Configuration File => ' | sed -e 's/Loaded Configuration File => //g' `;

echo "" > ${php_user_ini_path};
echo "memory_limit = -1" >> ${php_user_ini_path};
echo "date.timezone = UTC" >> ${php_user_ini_path};

pear install HTTP_Request2;
pear install PHP_CodeSniffer;

