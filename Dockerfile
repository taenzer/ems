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

RUN apk add --no-cache zlib-dev libpng-dev sqlite-dev curl-dev libzip-dev

# Installing NPM for dev server
RUN apk add --no-cache nodejs-current npm
RUN npm install concurrently --save-dev

RUN apk update && apk add --no-cache \
    autoconf \
    build-base \
    imagemagick \
    imagemagick-dev \
    libtool \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && apk del autoconf build-base libtool

RUN docker-php-ext-install gd pdo_sqlite pdo_mysql curl zip

RUN ln -sf /usr/bin/php82 /usr/bin/php

# Installing composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

EXPOSE 80