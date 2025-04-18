FROM 694783502979.dkr.ecr.eu-west-2.amazonaws.com/php7.4-base:latest AS base

# Install PHP extensions and MySQL client
RUN apt-get update && apt-get install -y \
    libzip-dev default-mysql-client \
    && docker-php-ext-install zip pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Copy composer files and install dependencies without scripts
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --optimize-autoloader --no-scripts

# Copy application files
COPY . .

# Ensure writable directories exist and are accessible
RUN mkdir -p storage/logs bootstrap/cache \
    && touch storage/logs/laravel.log \
    && chmod -R 775 storage bootstrap/cache

# Node build stage for assets
FROM node:16.20.2 AS node_build
WORKDIR /app
COPY --from=base /var/www/html /app

RUN npm install && npm run prod

# Final production image
FROM 694783502979.dkr.ecr.eu-west-2.amazonaws.com/php7.4-base:latest
WORKDIR /var/www/html

# Copy built Laravel app and frontend assets
COPY --from=base /var/www/html /var/www/html
COPY --from=node_build /app/public /var/www/html/public

# Set proper permissions
RUN mkdir -p storage/logs bootstrap/cache \
    && touch storage/logs/laravel.log \
    && chmod -R 775 storage bootstrap/cache

# Copy entrypoint script
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Run as root (default)
EXPOSE 8000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]