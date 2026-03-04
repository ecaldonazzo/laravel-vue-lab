#!/bin/bash
set -e

php artisan key:generate --force 2>/dev/null || true
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

php-fpm -D

php artisan reverb:start --host=0.0.0.0 --port=8081 &

nginx -g "daemon off;"