#!/usr/bin/env bash

export DEBIAN_FRONTEND=noninteractive;

apt-get update -y 2>&1;
apt-get install openssh-client wget git install openssl openssl-devel libssl-dev libcurl4-openssl-dev php-openssl install pear -y 2>&1;

unset DEBIAN_FRONTEND;