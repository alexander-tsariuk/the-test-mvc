FROM php:8.1-fpm-alpine

RUN apk update && apk upgrade

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www

COPY --from=composer /usr/bin/composer /usr/bin/composer
