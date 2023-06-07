FROM php:8.2-fpm-alpine as base

WORKDIR /app

# Install Docker PHP Extension Installer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Install required PHP extensions and tools
RUN install-php-extensions \
    bcmath \
    opcache \
    pdo_mysql \
    @composer

# Remove cache
RUN rm -rf /var/cache/apk/*

FROM base as composer_builder

COPY composer.json /app/composer.json
COPY composer.lock /app/composer.lock

RUN composer install --no-dev --no-scripts

FROM node:18-alpine3.17 as npm_install

WORKDIR /app

COPY . /app

RUN npm ci

RUN npm run build

FROM base as final

WORKDIR /app

ARG APP_VERSION
ENV APP_VERSION=${APP_VERSION}
ENV WEB_DOCUMENT_ROOT=/app/public

COPY . /app

COPY --from=npm_install /app/public/ /app/public
COPY --from=composer_builder /app/vendor /app/vendor

RUN ln -s /data/torrents /app/storage/app/torrents

RUN php artisan event:cache
RUN php artisan view:cache

EXPOSE 9000
CMD ["php-fpm"]
