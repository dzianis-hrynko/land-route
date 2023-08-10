FROM composer:2.5.1 as composerDocker

FROM php:8.2.2-cli-buster

WORKDIR /application

RUN apt update && \
    apt install -y zip unzip libzip-dev

RUN apt-get install -y \
  libpq-dev \
  libxml2-dev \
  nano


RUN docker-php-ext-configure zip --with-zip && \
    docker-php-ext-install \
      opcache \
      dom \
      exif \
      intl \
      pcntl \
      sockets

COPY --from=composerDocker /usr/bin/composer /usr/bin/composer

RUN /usr/bin/composer --version

COPY . /application

RUN composer install --prefer-dist

