#!/usr/bin/env bash

export DEBIAN_FRONTEND=noninteractive;

uname -a;

apt-get update -y 2>&1;
apt-get install openssh-client wget git openssl libssl-dev libcurl4-openssl-dev -y 2>&1;

unset DEBIAN_FRONTEND;
