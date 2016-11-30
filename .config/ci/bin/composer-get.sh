#!/usr/bin/env bash

set -e

if [[ -f './bin/composer' ]]; then
    ./bin/composer self-update;
else
    EXPECTED_SIGNATURE=$(wget https://composer.github.io/installer.sig -O - --quiet)
    wget --quiet --output-document composer-setup.php https://getcomposer.org/installer;
    ACTUAL_SIGNATURE=$(php -r "echo hash_file('SHA384', 'composer-setup.php');")

    if [ "${EXPECTED_SIGNATURE}" = "${ACTUAL_SIGNATURE}" ]
    then
        php composer-setup.php --install-dir=./bin/ --filename=composer
        RESULT=$?
        rm composer-setup.php
        chmod +x ./bin/composer;
    else
        echo 'Composer: Invalid installer signature'
        rm composer-setup.php
        exit 1
    fi
fi

#./bin/composer global require laktak/hjson

./bin/composer --version;
