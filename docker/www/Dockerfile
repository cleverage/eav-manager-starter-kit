# Base image is a ubuntu server image with some enhancements
FROM bluebeargaming/ubuntu-server

USER root

RUN add-apt-repository ppa:ondrej/php

# Custom php extensions
RUN apt-get update && apt-get install -y \
    mariadb-client \
    nginx \
    php7.2-fpm \
    php7.2-cli \
    php7.2-intl \
    php7.2-xml \
    php7.2-zip \
    php7.2-mbstring \
    php7.2-gd \
    php7.2-mysql \
    php7.2-curl \
    php-xdebug

# Fix fastcgi params in nginx
COPY nginx/snippets/php-fpm.conf /etc/nginx/snippets/php-fpm.conf

# Enabling our custom configs
COPY php/mods-available/symfony.ini /etc/php/7.2/mods-available/symfony.ini
COPY php/mods-available/xdebug.ini /etc/php/7.2/mods-available/xdebug.ini
RUN phpenmod symfony
# xdebug is already enabled by default

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY start.sh /var/www/start.sh

# DEV only - install PHPUnit
RUN wget https://phar.phpunit.de/phpunit-6.4.phar
RUN chmod +x phpunit-6.4.phar
RUN mv phpunit-6.4.phar /usr/local/bin/phpunit

# Rollback default shell
USER www-data

ENTRYPOINT ["/var/www/start.sh"]
