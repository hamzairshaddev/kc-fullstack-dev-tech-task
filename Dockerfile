FROM php:8.3-apache

# Install required tools and extensions
RUN apt-get update && \
    apt-get install -y zip unzip git && \
    docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Set the working directory
WORKDIR /var/www/html

# Copy only composer.json from the api folder
COPY composer.json ./

# Install dependencies
RUN composer install --no-scripts --no-autoloader

# Copy the contents of the api folder directly into /var/www/html
COPY api/ ./

# Copy the data directory into the container
COPY ./data /var/www/html/data

# Copy the migration files into the container
COPY database/migrations /docker-entrypoint-initdb.d/

# Regenerate the autoloader
RUN composer dump-autoload --optimize

# Copy the custom Apache configuration
COPY config/000-default.conf /etc/apache2/sites-available/000-default.conf

# Expose the default Apache port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]