#!/bin/bash
set -e

cd /var/www/html
cp .env.example .env

composer install --no-interaction

php artisan key:generate

chmod -R 777 storage bootstrap/cache

exec apache2-foreground