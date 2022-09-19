#!/usr/bin/env bash

php artisan tinker
php artisan migrate:refresh --seed
php artisan migrate
php artisan migrate --force
php artisan migrate:refresh
php artisan migrate:rollback
php artisan db:seed
vendor/bin/phpunit
# less +G storage/logs/laravel.log
php artisan config:clear
php artisan cache:clear
php artisan route:clear
xhp artisan route:cache
php artisan config:cache
php artisan key:generate
php artisan jwt:secret
