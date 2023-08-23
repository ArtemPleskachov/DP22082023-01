FROM php:8.2-fpm
ARG WORKDIR
WORKDIR ${WORKDIR}

RUN apt-get -y update && apt-get -y install git unzip vim rsync

RUN docker-php-ext-install pdo pdo_mysql

RUN pecl install xdebug && docker-php-ext-enable xdebug;
ENV PHP_IDE_CONFIG="serverName=host.docker.internal"

COPY ./docker/configs/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

ENV TERM xterm-256color
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer global require "laravel/installer"

WORKDIR /srv/src/app

CMD php-fpm
EXPOSE 9000