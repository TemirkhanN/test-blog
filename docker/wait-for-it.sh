#!/bin/sh
# wait-for-postgres.sh

cd /var/www/html

composer install --prefer-source --no-interaction
rm -rf var/cache/*
chown -R www-data:www-data var

echo db:5432:blog_db:blog:some_pass > ~/.pgpass
chmod 0600 ~/.pgpass

until psql -h "db" -U "blog" -d "blog_db"; do
  >&2 echo "Postgres is unavailable - sleeping"
  sleep 1
done


php bin/console doctrine:schema:create

php-fpm -F
