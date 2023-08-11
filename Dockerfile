# Use the official PHP 8.2 image
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && apt-get clean

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip

# Enable Apache Rewrite module
RUN a2enmod rewrite

# Set up the working directory
WORKDIR /var/www/html/php-laravel-demo

# Copy the Laravel application files into the container
# COPY . /var/www/html/php-demo

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Laravel dependencies
RUN composer install

# Install Node.js dependencies and compile assets
RUN npm install && npm run dev

# Set the Laravel application key
RUN php artisan key:generate

# Expose ports
EXPOSE 80

# Start the Apache server
# CMD ["apache2-foreground"]
