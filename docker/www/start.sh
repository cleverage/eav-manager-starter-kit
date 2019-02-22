#!/usr/bin/env bash

set -e

sudo service php7.2-fpm start
sudo service nginx start
sudo service supervisor start
sleep infinity
