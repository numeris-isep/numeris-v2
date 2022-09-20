#!/usr/bin/env sh

php artisan key:generate
php artisan jwt:secret
php artisan migrate:refresh --seed

exec docker-php-entrypoint
