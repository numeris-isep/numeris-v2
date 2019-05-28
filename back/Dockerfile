FROM php:7.2-apache

WORKDIR mkdir -p /home/numeris

# Install packages
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    nano

# Install the PHP mcrypt pdo_mysql extension
RUN docker-php-ext-install pdo_mysql

# Install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
# Enable apache conf
COPY docker/apache/numeris.conf /etc/apache2/sites-available/numeris.conf
RUN a2dissite 000-default.conf && a2ensite numeris.conf && a2enmod rewrite && service apache2 restart

COPY . /home/numeris

# Composer install
WORKDIR /home/numeris
RUN composer install --no-interaction

RUN . ~/.bashrc
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
RUN usermod -u 1000 www-data
RUN touch /home/numeris/storage/logs/scheduler.log
RUN chown -R www-data:www-data /home/numeris
RUN chown -R www-data:www-data /var/log/apache2/

WORKDIR /home/numeris