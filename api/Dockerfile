# Use official PHP FPM image with necessary extensions
FROM php:8.3-fpm-alpine

# Set working directory
WORKDIR /var/www

# Install required dependencies
RUN apk add --no-cache \
    bash \
    mysql-client \
    redis \
    zip unzip curl git \
    libpng-dev libjpeg-turbo-dev freetype-dev \
    libzip-dev libxml2-dev \
    oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring pdo pdo_mysql zip opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set correct permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
