#!/usr/bin/env sh

alias l='ls -alFh'

uname -a;
if [ -f '/etc/issue.net' ]; then
    cat /etc/issue.net;
else
    cat /etc/issue;
fi

if [ $(command -v apt-get) ]; then
    export DEBIAN_FRONTEND=noninteractive;
    apt-get install -y gnupg ncurses-term sha512sum git;
    unset DEBIAN_FRONTEND;
elif [ $(command -v apk) ]; then
    apk add --no-cache --repository http://dl-3.alpinelinux.org/alpine/edge/testing gnu-libiconv
    apk add gnupg ncurses git;

else
    echo 'OS not know';
    exit 4;
fi


#
#apt-get clean -yqq > /dev/null 2>&1;
#apt-get autoclean -yqq > /dev/null 2>&1;
#apt-get autoremove -yqq > /dev/null 2>&1;
#apt-get update -yqq > /dev/null 2>&1;
#
#apt-get install -yqq --no-install-recommends python-setuptools > /dev/null 2>&1;
#easy_install pip > /dev/null 2>&1;
#pip install shyaml > /dev/null 2>&1;
#
#OS_PACKAGES=$(cat ./.config/ci/os-software.yml | shyaml get-values os);
#apt-get install --no-install-recommends -yqq ${OS_PACKAGES} > /dev/null 2>&1;
#
#apt-get install -f -yqq > /dev/null;

