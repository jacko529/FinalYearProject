## PHP
FROM php:7.3-apache AS php
RUN apt-get update
RUN apt-get install -y libxml2-dev
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install \
    bcmath \
    ctype \
    json \
    mbstring \
    # this php extension causes docker-compose build to fail, but this isn't a
    # problem given that the openssl extension is installed by the base image
    # openssl \
    pdo \
    pdo_mysql \
    tokenizer \
    xml \
    mysqli
# RUN apt-get install php7.3-bcmath
RUN docker-php-ext-install bcmath.
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN a2enmod rewrite && service apache2 restart

COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf


