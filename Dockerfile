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


#RUN addgroup -g 1000 -S www && adduser -u 1000 -S www -G www

COPY . /var/www

RUN chown -R www-data:www-data /var/www

#USER www

EXPOSE 9000
