#!/usr/bin/env bash

set -e

PHING_VERSION='2.15.0';

if [[ ! -f './bin/phing' ]]; then
    printf '\a%s\n' 'Phing: not found, installing';

    EXPECTED_SIGNATURE=$(wget https://www.phing.info/get/phing-${PHING_VERSION}.phar.sha512 -O - --quiet);
    wget --quiet --output-document ./bin/phing https://www.phing.info/get/phing-${PHING_VERSION}.phar;
    ACTUAL_SIGNATURE=$(php -r "echo hash_file('SHA512', './bin/phing');");
    ACTUAL_SIGNATURE=${ACTUAL_SIGNATURE}" phing-${PHING_VERSION}.phar";

    if [[ "${EXPECTED_SIGNATURE}" = "${ACTUAL_SIGNATURE}" ]]; then
        chmod +x ./bin/phing;
    else
        printf '\a%s\n' 'Phing: Invalid signature!';
        printf '$ACTUAL_SIGNATURE: %s, $EXPECTED_SIGNATURE: %s\n' ${ACTUAL_SIGNATURE} ${EXPECTED_SIGNATURE};
        rm -rf ./bin/phing* phing* > /dev/null 2>&1
        exit 1
    fi
else
    printf '%s\n' 'Phing: found';
fi

./bin/phing -version;
