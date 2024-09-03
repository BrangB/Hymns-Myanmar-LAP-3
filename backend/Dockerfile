# Use the official PHP image
FROM php:8.1-apache

# Copy your application code to the /var/www/html directory
COPY . /var/www/html/

# Install any dependencies if required
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo_mysql mysqli \
    && a2enmod rewrite

# Expose port 80 to the outside world
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
