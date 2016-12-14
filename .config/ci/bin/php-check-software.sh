#!/usr/bin/env bash

set -e

if [[ ! -f './bin/phive' ]]; then
    wget --quiet --output-document ./bin/phive https://phar.io/releases/phive.phar;
    wget --quiet https://phar.io/releases/phive.phar.asc;
    gpg --keyserver hkps.pool.sks-keyservers.net --recv-keys 0x9B2D5D79 > /dev/null 2>&1;
#    if [[ `gpg --verify phive.phar.asc ./bin/phive > /dev/null 2>&1` ]]; then
        printf '\a%s\n' 'Phive: verified';
        chmod +x ./bin/phive;
        rm phive.phar.asc
#    else
#        printf '\a%s\n' 'Phive: Invalid signature!';
#        rm -rf ./bin/phive phive.phar*
#        exit 1
#    fi
else
    ./bin/phive self-update
    ./bin/phive version
fi

PHING_VERSION='latest';
if [[ ! -f './bin/phing' ]]; then
    printf '\a%s\n' 'Phing: not found, installing';

#    phive install phingofficial/phing --target ./bin/phing
#    phive install https://www.phing.info/get/phing-2.15.0.phar --target ./bin/phing

    EXPECTED_SIGNATURE=$(wget https://www.phing.info/get/phing-${PHING_VERSION}.phar.sha512 -O - --quiet);
    wget --quiet --output-document ./bin/phing https://www.phing.info/get/phing-${PHING_VERSION}.phar;
    ACTUAL_SIGNATURE=$(php -r "echo hash_file('SHA512', './bin/phing');");
    ACTUAL_SIGNATURE=${ACTUAL_SIGNATURE}" phing-${PHING_VERSION}.phar";

    if [[ "${EXPECTED_SIGNATURE}" == "${ACTUAL_SIGNATURE}" ]]; then
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

pear config-set auto_discover 1;
pear -qq channel-update pear.php.net;
pear -qq channel-discover pear.phing.info;

pear install pear.php.net/PHP_CodeSniffer;
pear install pear.pdepend.org/PHP_Depend-1.1.0;
pear install HTTP_Request2;
