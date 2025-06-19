FROM php:8.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Enable Apache rewrite
RUN a2enmod rewrite

# Copy app files
COPY . /var/www/html

# Set working dir
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port
EXPOSE 80

CMD ["apache2-foreground"]
