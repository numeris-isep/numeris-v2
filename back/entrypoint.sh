#!/usr/bin/env sh
echo ">>> Entrypoint démarré"

# Fix permissions
chown -R www-data:www-data /home/numeris/storage
chown -R www-data:www-data /home/numeris/bootstrap/cache
chmod -R 775 /home/numeris/storage
chmod -R 775 /home/numeris/bootstrap/cache

# Logfile setup
touch /home/numeris/storage/logs/laravel.log
chown www-data:www-data /home/numeris/storage/logs/laravel.log
chmod 664 /home/numeris/storage/logs/laravel.log

# Laravel setup
php artisan config:clear
php artisan key:generate
php artisan jwt:secret
php artisan migrate:refresh
# php artisan key:generate --force
# php artisan jwt:secret --force
# php artisan cache:clear

docker-php-entrypoint "$@"

# Start Apache
exec apache2-foreground
