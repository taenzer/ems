FROM php:8.2-fpm-alpine

WORKDIR /var/www/html/

# Essentials
RUN echo "UTC" > /etc/timezone
RUN apk update
RUN apk upgrade
RUN apk add --no-cache zip unzip curl sqlite nginx supervisor

# Installing bash
RUN apk add bash
RUN sed -i 's/bin\/ash/bin\/bash/g' /etc/passwd

RUN apk add --no-cache php82-pecl-redis

RUN apk add --no-cache imagemagick-dev zlib-dev libpng-dev sqlite-dev curl-dev libzip-dev

RUN docker-php-ext-install imagick gd pdo_sqlite pdo_mysql curl zip

RUN ln -s /usr/bin/php82 /usr/bin/php

# Installing composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

# Configure supervisor
# RUN mkdir -p /etc/supervisor.d/
# COPY .docker/supervisord.ini /etc/supervisor.d/supervisord.ini

# Configure PHP
RUN mkdir -p /run/php/
RUN touch /run/php/php8.2-fpm.pid

COPY .docker/php-fpm.conf /etc/php82/php-fpm.conf
COPY .docker/php.ini-production /etc/php82/php.ini

# Configure nginx
COPY .docker/nginx.conf /etc/nginx/
COPY .docker/nginx-laravel.conf /etc/nginx/modules/

RUN mkdir -p /run/nginx/
RUN touch /run/nginx/nginx.pid

RUN ln -sf /dev/stdout /var/log/nginx/access.log
RUN ln -sf /dev/stderr /var/log/nginx/error.log

# Building process
COPY . .
RUN composer install --no-dev
RUN chown -R nobody:nobody /var/www/html/storage

# Creating Storage Link
RUN php artisan storage:link

EXPOSE 80
CMD ["supervisord", "-c", "/etc/supervisor.d/supervisord.ini"]