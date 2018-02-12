#!/usr/bin/env sh

set -e

php_extension_install() {
    local extension=$1;
    local extension_loaded=$(php -r "echo (int)extension_loaded('${extension}');");
    if [ ${extension_loaded} == 0 ]; then
        printf "☐ Installing ${extension}\n";
        docker-php-ext-install ${extension};
    else
        printf "☑ Installed ${extension}\n";
    fi
}

pecl_extension_install() {
    local pecl_extension=$1;
    local extension="${pecl_extension/-beta/""}";
    local extension_loaded=$(php -r "echo (int)extension_loaded('${extension}');");
    if [ ${extension_loaded} == 0 ]; then
        printf "☐ Installing ${extension}\n";
        pecl install ${pecl_extension};
        docker-php-ext-enable ${extension};
    else
        printf "☑ Installed ${extension}\n";
    fi
}

php_extension_install "zip";
pecl_extension_install "xdebug";

php -m;

if [[ ! -f './bin/phive' ]]; then
    wget --quiet --output-document ./bin/phive https://phar.io/releases/phive.phar;
    wget --quiet https://phar.io/releases/phive.phar.asc;
    gpg --keyserver hkps.pool.sks-keyservers.net --recv-keys 0x9B2D5D79;
    gpg --batch --verify phive.phar.asc ./bin/phive;
    if [ $? -ne 0 ]; then
        printf '\a%s\n' 'Phive: Invalid signature!';
        rm -rf ./bin/phive phive.phar*
        exit 1
    else
        printf "\a%s\n" "Phive: verified";
        chmod +x ./bin/phive;
        rm phive.phar.asc
    fi
else
    ./bin/phive self-update
    ./bin/phive version
fi

./bin/phive install --no-progress --force-accept-unsigned composer/composer
./bin/phive install --no-progress --trust-gpg-keys 4AA394086372C20A,31C7E470E2138192,2A8299CE842DD38C,8E730BA25823D8B5,2420BAE0A3BE25C6

PHING_VERSION='latest';
if [[ ! -f './bin/phing' ]]; then
    printf "\a%s\n" "Phing: not found, installing";

    wget --quiet --output-document phing-${PHING_VERSION}.phar https://www.phing.info/get/phing-${PHING_VERSION}.phar;
    wget --quiet --output-document phing-${PHING_VERSION}.phar.sha512 https://www.phing.info/get/phing-${PHING_VERSION}.phar.sha512;
    sed -i "s/ /  /g" phing-${PHING_VERSION}.phar.sha512

    $(sha512sum -sc phing-${PHING_VERSION}.phar.sha512);
    PHING_STATUS=$?
    printf "%s %d\n" "Phing validate status:" ${PHING_STATUS};

    if [ ${PHING_STATUS} -ne 0 ]; then
        printf "\a%s\n" "[Warning!] Phing: Invalid signature!";
        rm -rf phing-*;
        exit 1
    else
        printf "\a%s\n" "Phing: Valid signature";
        mv phing-${PHING_VERSION}.phar ./bin/phing;
        chmod +x ./bin/phing;
    fi
else
    printf "%s\n" "Phing: found";
fi

./bin/phing -version;

pear config-set auto_discover 1;
pear -qq channel-update pear.php.net;
pear -qq channel-discover pear.phing.info;

pear install pear.php.net/PHP_CodeSniffer;
pear install pear.pdepend.org/PHP_Depend-1.1.0;
pear install HTTP_Request2;
