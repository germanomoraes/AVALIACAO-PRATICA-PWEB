#!/bin/sh
set -eu

mkdir -p \
    /var/www/database \
    /var/www/storage/framework/sessions \
    /var/www/storage/framework/cache \
    /var/www/storage/framework/views

touch /var/www/database/database.sqlite

php artisan config:clear
php artisan migrate --force

exec php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
