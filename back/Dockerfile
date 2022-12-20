FROM php:7.4-apache

# Install packages
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    nano \
    libpng-dev \
    libzip-dev


# Install the PHP mcrypt pdo_mysql extension
RUN docker-php-ext-install pdo_mysql gd zip

# Install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
# Enable apache conf
COPY docker/apache/numeris.conf /etc/apache2/sites-available/numeris.conf
RUN a2dissite 000-default.conf && \
      a2ensite numeris.conf && \
      a2enmod headers && \
      a2enmod rewrite && \
      service apache2 restart
# Enable php conf
COPY docker/php/php.ini /usr/local/etc/php/conf.d/default.ini

WORKDIR /home/numeris
COPY . .

# Composer install
RUN composer install --no-interaction

# Final touch
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
RUN usermod -u 1000 www-data
RUN chown -R www-data:www-data /home/numeris
RUN chown -R www-data:www-data /var/log/apache2/

# ENTRYPOINT [ "/home/numeris/entrypoint.sh" ]
ENTRYPOINT ["php", "artisan", "serve"]
