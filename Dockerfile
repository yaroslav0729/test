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

# Create required directories for Laravel logs and cache
RUN mkdir -p storage/logs bootstrap/cache \
    && touch storage/logs/laravel.log \
    && chmod -R 777 storage/logs bootstrap/cache

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

# Fix ownership and write access for Laravel cache (do NOT chmod/chown EFS storage)
RUN mkdir -p bootstrap/cache \
    && chmod -R 777 bootstrap/cache

# Create non-root user
RUN useradd -m -s /bin/bash appuser

# Copy entrypoint script
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Use non-root user
USER appuser

EXPOSE 8000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]