FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpq-dev libzip-dev libpng-dev libonig-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql mbstring zip gd

# Install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy Xdebug config
COPY ./docker/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Set workdir
WORKDIR /var/www/html

# Permissions
RUN chown -R www-data:www-data /var/www/html

CMD ["php-fpm"]
