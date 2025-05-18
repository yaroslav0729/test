############################
# 1 – PHP build stage
############################
FROM 694783502979.dkr.ecr.eu-west-2.amazonaws.com/php7.4-base:latest AS php-build
ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y --no-install-recommends \
        libzip-dev default-mysql-client && \
    docker-php-ext-install -j"$(nproc)" pdo_mysql zip && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN git config --global --add safe.directory /var/www/html && \
    composer install --no-dev --no-interaction --optimize-autoloader \
        --no-scripts --ignore-platform-req=php

COPY . .

RUN mkdir -p storage/logs bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache && \
    find storage bootstrap/cache -type d -exec chmod 775 {} \; && \
    find storage bootstrap/cache -type f -exec chmod 664 {} \;

############################
# 2 – Node build stage
############################
FROM node:16.20.2 AS node-build
WORKDIR /app
COPY --from=php-build /var/www/html /app
RUN npm i && npm run prod

############################
# 3 – Runtime image
############################
FROM 694783502979.dkr.ecr.eu-west-2.amazonaws.com/php7.4-base:latest AS runtime

# bring PHP extensions into the final image
COPY --from=php-build /usr/local/lib/php/extensions /usr/local/lib/php/extensions/
COPY --from=php-build /usr/local/etc/php/conf.d        /usr/local/etc/php/conf.d/

# non-root user
RUN addgroup --gid 1000 app && \
    adduser  --uid 1000 --gid 1000 --disabled-login --shell /usr/sbin/nologin appuser
# create storage link once, while we're still root
RUN php artisan storage:link --force \
 || ln -s ../storage/app/public /var/www/html/public/storage
WORKDIR /var/www/html

# application code + compiled assets
COPY --from=php-build /var/www/html /var/www/html
COPY --from=node-build /app/public   /var/www/html/public

# final permissions
RUN chown -R root:root /var/www/html && \
    chown -R appuser:app /var/www/html/storage /var/www/html/bootstrap/cache && \
    find /var/www/html -type d -exec chmod 755 {} \; && \
    find /var/www/html -type f -exec chmod 644 {} \; && \
    find /var/www/html/storage /var/www/html/bootstrap/cache -type d -exec chmod 775 {} \; && \
    find /var/www/html/storage /var/www/html/bootstrap/cache -type f -exec chmod 664 {} \; && \
    chown appuser:app /var/www/html/composer.json /var/www/html/composer.lock && \
    chmod 664       /var/www/html/composer.json /var/www/html/composer.lock

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

USER appuser
EXPOSE 8000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
