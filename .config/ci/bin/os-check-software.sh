#!/usr/bin/env bash

export DEBIAN_FRONTEND=noninteractive;

uname -a;
echo -e $(cat /etc/issue);

apt-get clean -yqq > /dev/null 2>&1;
apt-get autoclean -yqq > /dev/null 2>&1;
apt-get autoremove -yqq > /dev/null 2>&1;
apt-get update -yqq > /dev/null 2>&1;

apt-get install -yqq --no-install-recommends python-setuptools > /dev/null 2>&1;
easy_install pip > /dev/null 2>&1;
pip install shyaml > /dev/null 2>&1;

OS_PACKAGES=$(cat ./.config/ci/os-software.yml | shyaml get-values os);
apt-get install --no-install-recommends -yqq ${OS_PACKAGES} > /dev/null 2>&1;

apt-get install -f -yqq > /dev/null;
unset DEBIAN_FRONTEND;
