#!/usr/bin/env bash

# Piotr Żuralski <piotr@zuralski.net>
# copyright 2015 zuralski.net

_pwd=$(pwd -P);
if [[ ${_pwd} == */bin ]]; then
    cd ../;
    _pwd=$(pwd -P);
fi

#source ${_pwd}/bin/build.sh;

mkdir -p builds/
./bin/php-cs-fixer.phar fix . --verbose

./bin/phing.phar qc:phpcbf php-cs-fixer

source ./bin/build.sh