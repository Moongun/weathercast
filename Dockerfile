FROM php:8.2-fpm-alpine

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"


COPY --from=composer:2.6 /usr/bin/composer /usr/local/bin/composer

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN docker-php-ext-install opcache

RUN apk add --no-cache $PHPIZE_DEPS
RUN apk add --update linux-headers
RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY conf.d/ $PHP_INI_DIR/conf.d/

WORKDIR /code