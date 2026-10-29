# Multi-Stage Production Dockerfile for Kashmir Sheeps Marketplace
# PHP 8.4 FPM Alpine Base
FROM php:8.4-fpm-alpine AS base

# Install system dependencies
RUN apk add --no-cache \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    linux-headers \
    supervisor

# Install PHP extensions
RUN docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_sqlite \
    mbstring \
    exif \
    pcntl \
    bcmath \
    intl \
    zip \
    opcache

# Install Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Production OPcache configuration
RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.enable_cli=1'; \
    echo 'opcache.memory_consumption=256'; \
    echo 'opcache.interned_strings_buffer=16'; \
    echo 'opcache.max_accelerated_files=20000'; \
    echo 'opcache.validate_timestamps=0'; \
    echo 'opcache.save_comments=1'; \
    echo 'opcache.fast_shutdown=1'; \
} > /usr/local/etc/php/conf.d/opcache-recommended.ini

# Set working directory
WORKDIR /var/www/html

# Copy composer definition first to leverage Docker layer caching
COPY composer.json composer.lock ./

# Install production dependencies without dev packages
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist --optimize-autoloader

# Copy application source code
COPY . .

# Set permissions for Laravel storage and cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Make entrypoint executable
RUN chmod +x /var/www/html/docker/entrypoint.sh

# Expose PHP-FPM port
EXPOSE 9000

ENTRYPOINT ["/var/www/html/docker/entrypoint.sh"]
CMD ["php-fpm"]
