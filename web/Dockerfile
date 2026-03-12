FROM php:8.2-fpm-alpine

RUN apk add --no-cache postgresql-dev curl-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && docker-php-ext-enable opcache \
    && docker-php-ext-install curl