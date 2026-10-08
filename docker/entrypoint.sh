#!/bin/sh
set -eu

cd /var/www/html

mkdir -p \
    storage/app/private \
    storage/app/public \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache

su -s /bin/sh -c 'php artisan migrate --force --no-interaction' www-data

exec "$@"
