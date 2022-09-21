#!/usr/bin/env sh

php artisan key:generate --force
php artisan jwt:secret --force
php artisan migrate:refresh --seed --force

docker-php-entrypoint
apache2-foreground
