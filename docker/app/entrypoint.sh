#!/bin/bash
set -e

uid=$(stat -c %u /var/www/html)
gid=$(stat -c %g /var/www/html)

# Change www-data's uid & guid to be the same as directory in host
sed -ie "s/`id -u www-data`:`id -g www-data`/$uid:$gid/g" /etc/passwd

if [ "$1" = 'php-fpm' ]; then
  php-fpm -R
else
  su www-data -s /bin/bash -c "$*"
fi
