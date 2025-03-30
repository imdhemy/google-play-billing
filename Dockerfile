FROM php:8.3-cli

# Install Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Ensure the vendor directory exists
RUN mkdir -p /app/vendor
