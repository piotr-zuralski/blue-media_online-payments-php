#!/bin/bash

# Piotr Żuralski <piotr@zuralski.net>
# copyright 2015 zuralski.net

_pwd=$(pwd -P);
if [[ ${_pwd} == */bin ]]; then
    cd ../;
    _pwd=$(pwd -P);
fi

source ${_pwd}/bin/build.sh;

if [ -f "./bin/php-cs-fixer" ]; then
    ./bin/php-cs-fixer fix . --verbose
fi
