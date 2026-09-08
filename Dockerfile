# syntax=docker/dockerfile:1

FROM serversideup/php:8.4-fpm-nginx-alpine AS base

USER root

# Only bcmath is missing from the image's default extension set, which already
# provides opcache, pcntl, pdo_mysql, pdo_pgsql, redis and zip
RUN install-php-extensions bcmath

USER www-data

FROM base AS composer_builder

COPY --chown=www-data:www-data composer.json composer.lock ./

# The application source is not present in this stage, so the optimised
# autoloader is generated in the final stage once the source is available.
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --no-interaction \
    --no-progress

FROM node:lts-alpine AS npm_install

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci

COPY vite.config.js ./
COPY resources ./resources

# Tailwind scans Blade templates and stylesheets shipped by the dependencies
COPY --from=composer_builder /var/www/html/vendor ./vendor

RUN npm run build

FROM base AS final

ARG APP_VERSION
ENV APP_VERSION=${APP_VERSION}

# The image ships with OPcache installed but disabled
ENV PHP_OPCACHE_ENABLE=1

COPY --chown=www-data:www-data . ./

COPY --from=npm_install --chown=www-data:www-data /app/public/build ./public/build
COPY --from=composer_builder --chown=www-data:www-data /var/www/html/vendor ./vendor

RUN composer dump-autoload --no-dev --optimize

RUN ln -s /data/torrents ./storage/app/torrents

RUN php artisan event:cache
RUN php artisan view:cache
