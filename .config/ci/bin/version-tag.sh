#!/usr/bin/env sh

set -e

VERSION=`cat ./version.txt`
NOW=`date -u +"%Y-%m-%dT%H:%M:%S%:z"`
VERSION_SED=${VERSION} | sed -e 's/v//g' | sed -e 's/.//g' | sed -e 's/0//g'
OVERRIDE_TAG=0;

###########################################

if [ ${BITBUCKET_TAG} ]; then
    CI_BUILD_TAG=${BITBUCKET_TAG};
fi

if [ ${BITBUCKET_COMMIT} ]; then
    CI_BUILD_REF=${BITBUCKET_COMMIT};
fi

if [ ${BITBUCKET_BRANCH} ]; then
    CI_BUILD_REF_NAME=${BITBUCKET_BRANCH};
fi

###########################################

if [ ! -z "${CI_BUILD_TAG}" ]; then
    printf 'Build on tag - softfail\n';
    exit;
fi

if [ ! -z "${CI_BUILD_REF}" ]; then
    printf 'Commit ref empty!\n';
    exit 1;
fi

printf 'VERSION: "%s"\n' ${VERSION};
printf 'VERSION_SED: "%s"\n' ${VERSION_SED};

if [ -z "${VERSION_SED}" ]; then
    printf 'Version empty!';
    exit;
fi

if [ `git tag -l | grep -q ${VERSION}` ]; then
    printf 'Version: %s already exists\n' ${VERSION};

    if [ ${OVERRIDE_TAG} ]; then
        printf 'Removing tag\n';
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
