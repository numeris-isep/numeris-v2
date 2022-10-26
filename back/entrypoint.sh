#!/usr/bin/env sh

php artisan key:generate
# php artisan key:generate --force
php artisan jwt:secret
# php artisan jwt:secret --force
# php artisan cache:clear
php artisan config:clear
php artisan migrate:refresh

docker-php-entrypoint
apache2-foreground
