#!/usr/bin/env bash

set -e

if [[ ! -f './bin/phive' ]]; then
    wget --quiet --output-document ./bin/phive https://phar.io/releases/phive.phar;
    wget --quiet https://phar.io/releases/phive.phar.asc;
    gpg --keyserver hkps.pool.sks-keyservers.net --recv-keys 0x9B2D5D79 > /dev/null;
    gpg --batch --verify phive.phar.asc ./bin/phive > /dev/null;
    if [[ $? -ne 0 ]]; then
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

PHING_VERSION='latest';
if [[ ! -f './bin/phing' ]]; then
    printf "\a%s\n" "Phing: not found, installing";

    EXPECTED_SIGNATURE=$(wget https://www.phing.info/get/phing-${PHING_VERSION}.phar.sha512 -O - --quiet);
    EXPECTED_SIGNATURE="${EXPECTED_SIGNATURE/ phing-${PHING_VERSION}.phar/""}";
    EXPECTED_SIGNATURE="${EXPECTED_SIGNATURE/ /""}";
    wget --quiet --output-document ./bin/phing https://www.phing.info/get/phing-${PHING_VERSION}.phar;
    ACTUAL_SIGNATURE=$(sha512sum ./bin/phing);
    ACTUAL_SIGNATURE="${ACTUAL_SIGNATURE/ .\/bin\/phing/""}";
    ACTUAL_SIGNATURE="${ACTUAL_SIGNATURE/ /""}";

    if [[ "${EXPECTED_SIGNATURE}" == "${ACTUAL_SIGNATURE}" ]]; then
        chmod +x ./bin/phing;
    else
        printf "\a%s\n" "[Warning!] Phing: Invalid signature!";
        printf "  ACTUAL: %s\n" ${ACTUAL_SIGNATURE};
        printf " ACTUAL2: %s\n" $(php -r "echo hash_file('SHA512', './bin/phing');");
        printf "EXPECTED: %s\n" ${EXPECTED_SIGNATURE};
        chmod +x ./bin/phing;

        # rm -rf ./bin/phing* phing* > /dev/null 2>&1
        # exit 1
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
