#!/bin/sh
# wait-for-postgres.sh

cd /var/www/html
composer install --prefer-source --no-interaction
chown -R www-data:www-data ./var
rm -rf var/cache/*

php bin/console doctrine:schema:create

php-fpm -F