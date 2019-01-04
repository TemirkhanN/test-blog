#!/bin/sh
# init.sh

cd /var/www/html

composer install --prefer-source --no-interaction

sleep 5

php bin/console doctrine:migrations:migrate --no-interaction
php bin/console cache:warmup --env=dev
php bin/console cache:warmup --env=prod

chown -R www-data:www-data ./var

php-fpm -F
