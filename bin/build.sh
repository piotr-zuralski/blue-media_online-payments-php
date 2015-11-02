#!/bin/bash

# Piotr Żuralski <piotr@zuralski.net>
# copyright 2015 zuralski.net

if [[ `pwd` == */bin ]]; then
    cd ../;
fi

COMPOSER="composer"
if [ ! $COMPOSER ]; then
    if [ ! "./bin/composer" ]; then
        curl -sS https://getcomposer.org/installer | php -- --install-dir=`pwd`/bin --filename=composer;
        $COMPOSER="./bin/composer";
    else
        $COMPOSER="./bin/composer";
    fi
fi

if [ "composer" ]; then
    composer self-update;
    composer update;
fi

cd .git/hooks/;
ln -s ../../.git-config/hooks/pre-commit . ;
cd -;