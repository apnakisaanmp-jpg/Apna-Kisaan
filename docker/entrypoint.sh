#!/bin/sh
set -eu

cd /var/www/html

if [ -n "${RENDER_SERVICE_ID:-}" ] \
    && [ "${DB_CONNECTION:-}" = "pgsql" ] \
    && [ -z "${DB_URL:-}" ]; then
    echo >&2 "Render PostgreSQL is not configured: set DB_URL to the database's Internal Database URL in the web service environment."
    echo >&2 "Remove stale DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD values from the Render web service."
    exit 1
fi

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
