##!/usr/bin/env sh
#
#set -e
#
#SOURCE="${BASH_SOURCE[0]}"
#DIR="$( cd -P "$( dirname "$SOURCE" )" && pwd )"
#PHP_VERSION_REQUIRED="5.3.0";
#export PHP_VERSION=$(php -f ${DIR}/php-version.php)
#
#printf "PHP version: %s\n" ${PHP_VERSION};
#if [ $(php -r "echo (int)version_compare('${PHP_VERSION}', '${PHP_VERSION_REQUIRED}', '>=');") = 0 ]; then
#    printf "PHP version under \"%s\", phpverion: \"%s\"\n" ${PHP_VERSION_REQUIRED} ${PHP_VERSION};
#    exit 1;
#fi
#
#if [ $(php -r "echo (int)version_compare('${PHP_VERSION}', '7.0', '>=');") = 1 ]; then
#    printf "PHP version greater than \"7.0\", apcu is required\n";
#    echo -e "  - apcu\n" >> ${DIR}/../php-pecl-packages.yml;
#
#    # if [ ! type "phpdbg" > /dev/null ]; then
#        # docker-php-source extract;
#        # cd /usr/src/php;
#
#        # ./configure --enable-phpdbg > /dev/null;
#        # make > /dev/null;
#        # make install > /dev/null;
#        # make clean > /dev/null;
#        # docker-php-source delete;
#    # fi
#
#else
#    printf "PHP version less than \"7.0\", apc is required\n";
#    echo -e "  - apc\n" >> ${DIR}/../php-pecl-packages.yml;
#
#    # TODO: add phpdbg to compile
#fi
#
##docker-php-ext-install
##docker-php-entrypoint
##docker-php-ext-configure
##docker-php-ext-enable
##docker-php-ext-install
##docker-php-source
#
#php_extension_install() {
#    local extension=$1;
#    local extension_loaded=$(php -r "echo (int)extension_loaded(${extension});");
#    if [ ${extension_loaded} = 0 ]; then
#        printf "☐ Installing ${extension}\n";
#        docker-php-ext-install ${extension};
#    else
#        printf "☑ Installed ${extension}\n";
#    fi
#}
#
#pecl_extension_install() {
#    local pecl_extension=$1;
#    local extension="${pecl_extension/-beta/""}";
#    local extension_loaded=$(php -r "echo (int)extension_loaded(${extension});");
#    if [ ${extension_loaded} = 0 ]; then
#        printf "☐ Installing ${extension}\n";
#        pecl install ${pecl_extension} > /dev/null 2>&1;
#        docker-php-ext-enable ${extension} > /dev/null 2>&1;
#    else
#        printf "☑ Installed ${extension}\n";
#    fi
#}
#
## docker-php-ext-configure imap --with-kerberos --with-imap-ssl > /dev/null 2>&1;
## docker-php-ext-install imap > /dev/null 2>&1;
#
## docker-php-ext-configure gd --with-freetype-dir=/usr --with-png-dir=/usr --with-jpeg-dir=/usr > /dev/null 2>&1;
## docker-php-ext-install gd > /dev/null 2>&1;
#
## docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ > /dev/null 2>&1;
## docker-php-ext-install ldap > /dev/null 2>&1;
#
#PHP_EXTENSIONS=$(cat ${DIR}/../php-php-extensions.yml | shyaml get-values php);
#if [ ! -z "${PHP_EXTENSIONS}" ]; then
#    for extension in ${PHP_EXTENSIONS}
#    do
#        php_extension_install $extension;
#    done
#fi
#
#PHP_PECL_PACKAGES=$(cat ${DIR}/../php-pecl-packages.yml | shyaml get-values pecl);
#if [ ! -z "${PHP_PECL_PACKAGES}" ]; then
#    for package in ${PHP_PECL_PACKAGES}
#    do
#        pecl_extension_install $package;
#    done
#fi
#
#php_user_ini_path=`php -r "echo ini_get('user_ini.filename');"`
#php_ini_path=`php -i | grep -i 'Loaded Configuration File => ' | sed -e 's/Loaded Configuration File => //g' `;
#
#echo "" > ${php_user_ini_path};
#echo "memory_limit = -1" >> ${php_user_ini_path};
#echo "date.timezone = UTC" >> ${php_user_ini_path};
#
#php -m;
#
#php -f ${DIR}/php-check-extensions.php;
