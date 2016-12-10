#!/usr/bin/env bash

set -e

VERSION=`cat ./version.txt`
NOW=`date +"%Y-%m-%d %H:%M:%S.%N%:z (%Z)"`
VERSION_SED=${VERSION} | sed -e 's/v//g' | sed -e 's/.//g' | sed -e 's/0//g'
OVERRIDE_TAG=0;

###########################################

if [[ ${BITBUCKET_TAG} ]]; then
    CI_BUILD_TAG=${BITBUCKET_TAG};
fi

if [[ ${BITBUCKET_COMMIT} ]]; then
    CI_BUILD_REF=${BITBUCKET_COMMIT};
fi

if [[ ${BITBUCKET_BRANCH} ]]; then
    CI_BUILD_REF_NAME=${BITBUCKET_BRANCH};
fi

###########################################

if [[ ! -z "${CI_BUILD_TAG}" ]]; then
    echo -e 'Build on tag - softfail';
    exit;
fi

if [[ ! -z "${CI_BUILD_REF}" ]]; then
    echo -e 'Commit ref empty!';
    exit 1;
fi

echo '${VERSION}: "'${VERSION}'"';
echo '${VERSION_SED}: "'${VERSION_SED}'"';

if [[ -z "${VERSION_SED}" ]]; then
    echo "Version empty!"
    exit;
fi

if [[ `git tag -l | grep -q ${VERSION}` ]]; then
    echo "Version: ${VERSION} already exists\n";

    if [[ ${OVERRIDE_TAG} ]]; then
        echo "Removing tag\n";
        git tag -d ${VERSION};
        git push origin :${VERSION};
    else
        exit 1;
    fi
fi

message="Version: ${VERSION} at ${NOW} on build: ${CI_BUILD_REF}";
echo "Creating "${message};

#git tag -a ${VERSION} -m ${message};
#git push origin ${VERSION}
