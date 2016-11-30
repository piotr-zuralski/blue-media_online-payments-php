#!/usr/bin/env bash

export DEBIAN_FRONTEND=noninteractive;

apt-get update -yq > /dev/null 2>&1;
apt-get install openssl openssh-client wget git -yq > /dev/null 2>&1;
apt-get install php-openssl -yq > /dev/null 2>&1;

unset DEBIAN_FRONTEND;