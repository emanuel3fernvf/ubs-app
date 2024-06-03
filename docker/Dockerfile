FROM php:8.3-fpm-alpine

# Update list of package manager
RUN apk update

# Install dependencies to sockets and xdebug
RUN apk add --update linux-headers

# Configure system timezone to America/Sao_Paulo
RUN apk add --no-cache tzdata \
    && cp /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime \
    && echo "America/Sao_Paulo" > /etc/timezone \
    && apk del tzdata

# Configure PHP custom.ini
COPY ./php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Install dependencies to PHPIZE
RUN apk add $PHPIZE_DEPS

# Install zip dependencies to PHP and System
RUN apk add zip unzip libzip-dev

# Install dependencies and GD lib to PHP
RUN apk add libpng-dev libjpeg-turbo-dev libwebp-dev libxpm-dev freetype-dev

RUN docker-php-ext-configure gd --with-jpeg --with-freetype && docker-php-ext-install gd

# Install system utilities
RUN apk add nano openssh git curl bash

# Install and set config to Nginx
RUN apk add nginx
COPY ./nginx/custom.conf /etc/nginx/nginx.conf

# Install and set config to Supervisor
RUN apk add supervisor
COPY ./supervisor/supervisor.conf /etc/supervisor/conf.d/supervisord.conf

# Install and set config to Xdebug (only in local environment)
COPY ./php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Clear package manager cache
RUN rm -rf /var/cache/apk/*

# Install Redis and enable this extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install sockets to AMQP
RUN docker-php-ext-install sockets

# Install PDO and PDO_MYSQL extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install others extensions in PHP
RUN docker-php-ext-install pcntl bcmath

# Expose ports
EXPOSE 80

# Set workdir
WORKDIR /var/www

# Set entrypoint command
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
