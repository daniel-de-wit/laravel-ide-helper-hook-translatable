FROM php:8.1-cli-alpine

WORKDIR /var/www/html

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache \
        icu-libs \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        icu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && pecl install \
        pcov \
    && docker-php-ext-enable \
        pcov \
    && apk del .build-deps

COPY conf.d /usr/local/etc/php/conf.d
