
FROM php:8.2.5-apache

RUN apt-get update -y && apt-get install -y libmcrypt-dev \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    zip \
    curl \
    unzip \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install sockets \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-source delete \
    && apt-get clean

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html/php-laravel-demo

RUN composer install
RUN npm install && npm run dev

EXPOSE 8000
