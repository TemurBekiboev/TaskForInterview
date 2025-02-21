# Use official PHP image
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy Laravel project
COPY . .

# Install dependencies
RUN composer install --no-interaction --prefer-dist

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

CMD ["php-fpm"]
