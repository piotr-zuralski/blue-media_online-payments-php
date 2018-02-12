#!/usr/bin/env sh

# Piotr Żuralski <piotr@zuralski.net>
# copyright 2015 zuralski.net

_pwd=$(pwd -P);
if [[ ${_pwd} == */bin ]]; then
    cd ../;
    _pwd=$(pwd -P);
fi

#source ${_pwd}/bin/build.sh;

mkdir -p builds/
if [ ! -f "./bin/php-cs-fixer" ]; then
    wget https://github.com/FriendsOfPHP/PHP-CS-Fixer/releases/download/v2.13.1/php-cs-fixer.phar -o /dev/null -O bin/php-cs-fixer;
    chmod +x bin/php-cs-fixer;
fi

if [ -f "./bin/php-cs-fixer" ]; then
    ./bin/php-cs-fixer fix . --verbose
fi

./bin/phing qc:phpcbf,php-cs-fixer

source ./bin/build.sh