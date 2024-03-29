FROM php:7.4-fpm

# CONFIGURE
RUN apt-get update && \
    apt-get install --fix-missing -y  \
                memcached  \
                htop \
                zip \
                unzip  \
                build-essential  \
                wget  \
                ssh  \
                locales  \
                mc  \
                nano  \
                supervisor \
                libbz2-dev \
                libssl-dev \
                libpng-dev \
                libmagickwand-dev \
                libmagickcore-dev \
                libicu-dev \
                libmcrypt-dev \
                libmemcached-dev \
                libpq-dev \
                libssh2-1-dev \
                libxml2-dev \
                libxslt1-dev \
                zlib1g-dev \
                gettext \
                cron \
                git \
                nginx \
                gnupg \
                libzip-dev \
                g++ \
                ca-certificates \
                lsb-release \
                software-properties-common

RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/

RUN docker-php-ext-install -j$(nproc) bz2 \
                                      calendar \
                                      exif \
                                      gd \
                                      gettext \
                                      intl \
                                      pcntl \
                                      mysqli \
                                      pdo_mysql \
                                      shmop \
                                      sockets \
                                      sysvmsg \
                                      sysvsem \
                                      sysvshm \
                                      xsl \
                                      zip \
                                      bcmath \
                                      intl

RUN docker-php-ext-configure intl && \
    docker-php-ext-configure sockets  && \
    pecl install channel://pecl.php.net/igbinary \
                 imagick \
                 memcached \
                 msgpack \
                 redis \
                 mcrypt-1.0.2

RUN docker-php-ext-enable igbinary imagick memcached msgpack redis && \
    sed -i 's/# \(ru_RU.UTF-8 UTF-8\)/\1/g' /etc/locale.gen && locale-gen && update-locale "ru_RU.UTF-8" && \
    export LC_CTYPE=en_US.UTF-8 && \
    export LC_ALL=en_US.UTF-8 && \
    locale-gen && \
    pecl install xdebug-2.9.8 && docker-php-ext-enable xdebug

# CREATE LOG DIR
RUN mkdir -p /etc/supervisor && \
    mkdir -p /var/log/php-fpm && \
#    mkdir -p /usr/local/etc/php-fpm.d && \
    mkdir -p /var/log/nginx && \
    rm -rf /var/lib/apt/lists/* && \
    mkdir -p /src

# SETUP PERMAMENT VOLUMES
VOLUME /var/log/php-fpm
VOLUME /var/log/nginx

# CONFIGURATION PHP
#COPY ./docker/php/fpm/ /usr/local/etc/php-fpm.d/
COPY ./src/composer.json $APP_PATH
COPY ./src /src

# INSTALL TOOLS
RUN curl -L https://getcomposer.org/installer >> composer-setup.php && \
      php composer-setup.php && \
      mv composer.phar /usr/local/bin/composer && \
      composer config --global --auth github-oauth.github.com  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 && \
      chmod -R 0777 /src/web/assets && \
      chmod -R 0777 /src/runtime

WORKDIR /src

USER root
#RUN useradd -ms /bin/bash yii_docker
#USER yii_docker
