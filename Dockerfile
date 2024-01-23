# Use an official PHP 8.2 image
FROM php:8.2-fpm

# Set the working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && \
    apt-get install -y \
        libzip-dev \
        unzip \
        nodejs \
        npm

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - && \
    apt-get install -y nodejs

# Install Laravel dependencies
COPY composer.json ./
COPY package.json ./
RUN composer install --no-scripts
RUN npm install

# Copy application files
COPY . .

# Copy initialization script
COPY init.sql /docker-entrypoint-initdb.d/

# Install Laravel dependencies
RUN composer install --no-scripts
RUN npm install

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 8000
EXPOSE 8000

# Start Laravel
CMD ["sh", "-c", "php artisan migrate --seed && php artisan serve --host=0.0.0.0 --port=8000"]