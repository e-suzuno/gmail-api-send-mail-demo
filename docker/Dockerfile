FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
zip \
unzip

COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer