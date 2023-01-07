FROM ubuntu:22.04

LABEL maintainer="Taylor Otwell"

ARG WWWGROUP
ARG NODE_VERSION=18
ARG POSTGRES_VERSION=14

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
    && apt-get install -y gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python2 \
    && curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x14aa40ec0831756756d7f66c4f4ea0aae5267a6c' | gpg --dearmor | tee /usr/share/keyrings/ppa_ondrej_php.gpg > /dev/null \
    && echo "deb [signed-by=/usr/share/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu jammy main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get install -y php8.1-cli php8.1-dev \
       php8.1-pgsql php8.1-sqlite3 php8.1-gd \
       php8.1-curl \
       php8.1-imap php8.1-mysql php8.1-mbstring \
       php8.1-xml php8.1-zip php8.1-bcmath php8.1-soap \
       php8.1-intl php8.1-readline \
       php8.1-ldap \
       php8.1-msgpack php8.1-igbinary php8.1-redis php8.1-swoole \
       php8.1-memcached php8.1-pcov php8.1-xdebug \
    && php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -sLS https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm \
    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | gpg --dearmor | tee /usr/share/keyrings/yarn.gpg >/dev/null \
    && echo "deb [signed-by=/usr/share/keyrings/yarn.gpg] https://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list \
    && curl -sS https://www.postgresql.org/media/keys/ACCC4CF8.asc | gpg --dearmor | tee /usr/share/keyrings/pgdg.gpg >/dev/null \
    && echo "deb [signed-by=/usr/share/keyrings/pgdg.gpg] http://apt.postgresql.org/pub/repos/apt jammy-pgdg main" > /etc/apt/sources.list.d/pgdg.list \
    && apt-get update \
    && apt-get install -y yarn \
    && apt-get install -y mysql-client \
    && apt-get install -y postgresql-client-$POSTGRES_VERSION \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.1

COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
# ADD docker/app/supervisor.conf /etc/supervisor/conf.d/worker.con
COPY docker/app/php.ini   $PHP_INI_DIR/conf.d/
RUN chmod +x /usr/local/bin/start-container

EXPOSE 8000

ENTRYPOINT ["start-container"]




#  EWNEWNEWNEWNW
# ARG PHP_VERSION="7.4"
# FROM php:${PHP_VERSION}-fpm
# RUN apt-get update && apt-get -y --no-install-recommends install \
# git \
# curl \
# libpng-dev \
# libonig-dev \
# libxml2-dev \
# zip \
# unzip \
# supervisor \
# && apt-get autoremove --purge -y && apt-get clean \
# && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
# RUN docker-php-ext-install -j$(nproc) \
# opcache \
# intl \
# pdo_mysql \
# mbstring \
# exif \
# pcntl \
# bcmath \
# gd
# RUN pecl install apcu-5.1.20 && docker-php-ext-enable apcu
# COPY docker/app/php.ini   $PHP_INI_DIR/conf.d/
# RUN curl -sS https://getcomposer.org/installer | \
# php -- --install-dir=/usr/local/bin --filename=composer
# WORKDIR /var/www/app
# COPY . /var/www/app
# RUN composer update 
# ADD docker/app/supervisor.conf /etc/supervisor/conf.d/worker.conf