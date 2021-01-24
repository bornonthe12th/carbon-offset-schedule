FROM php:7.3-fpm-alpine

WORKDIR /var/www

RUN apk update && apk add  \
        build-base \
        libzip-dev \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libzip-dev \
        zip \
        jpegoptim optipng pngquant gifsicle \
        vim \
        unzip \
        git \
        curl

RUN docker-php-ext-configure zip --with-libzip=/usr/include && docker-php-ext-install zip

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl

RUN docker-php-ext-configure gd \
        --with-freetype-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
        --with-png-dir=/usr/include/ \
        --with-gd

RUN docker-php-ext-install gd

# Development additions
RUN apk add --no-cache $PHPIZE_DEPS && pecl install xdebug-2.7.2 \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN addgroup -g 1000 -S www && adduser -u 1000 -S www -G www

USER www

EXPOSE 9000
