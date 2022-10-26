#!/usr/bin/env sh

php artisan key:generate --force
php artisan jwt:secret --force
# php artisan cache:clear
php artisan config:clear
php artisan migrate:refresh --force

docker-php-entrypoint
apache2-foreground
