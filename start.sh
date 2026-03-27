#!/bin/bash

cd /var/www/html

# Fix permissions
chmod -R 777 storage bootstrap/cache
mkdir -p storage/logs
touch storage/logs/laravel.log
chmod 777 storage/logs/laravel.log

php artisan migrate --force
php artisan storage:link
php artisan config:clear
php artisan config:cache
php artisan route:cache

apache2-foreground
