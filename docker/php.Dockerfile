## PHP
FROM php:7.4.3-buster AS php

RUN apt-get update
RUN apt-get install -y libxml2-dev
RUN apt-get install -y libonig-dev
RUN apt-get install -y libzip-dev
RUN apt-get install -y unzip
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install \
    bcmath \
    ctype \
    json \
    pdo \
    pdo_mysql \
    tokenizer \
    xml \
    mysqli \
    zip

RUN apt-get install vim -y && \
    apt-get install openssl -y && \
    apt-get install libssl-dev -y && \
    apt-get install wget -y

RUN pecl install swoole
RUN pecl install inotify
RUN docker-php-ext-enable swoole

RUN touch /usr/local/etc/php/conf.d/swoole.ini && \
    echo 'extension=swoole.so' > /usr/local/etc/php/conf.d/swoole.ini


RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# RUN php -i | grep php.ini && echo "extension=swoole.so" >> php.ini  && echo "'extension=inotify.so'" >> php.ini
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html/


