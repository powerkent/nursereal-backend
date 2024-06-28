ARG PHP_VERSION=8.2
ARG COMPOSER_VERSION=2

FROM composer:${COMPOSER_VERSION} AS nurs-composer

FROM php:${PHP_VERSION}-fpm AS nurs-common

RUN docker-php-ext-install pdo_mysql

RUN apt-get update && apt-get install -y --no-install-recommends \
    wget \
    unzip \
    gnupg2 \
    nano

COPY --from=nurs-composer /usr/bin/composer /usr/bin/composer
RUN mkdir /var/www/.composer/ && chmod +w /var/www/.composer/

WORKDIR /var/www/html

EXPOSE 9000

FROM nurs-common AS nurs-php-dev

COPY docker/app/entrypoint.sh /usr/local/bin/entrypoint

RUN pecl install pcov \
    && docker-php-ext-enable pcov \
    && chmod +x /usr/local/bin/entrypoint

EXPOSE 8080

ENTRYPOINT ["entrypoint"]
CMD [ "php-fpm" ]
