FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql pgsql gd mbstring zip \
    && docker-php-ext-install intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
