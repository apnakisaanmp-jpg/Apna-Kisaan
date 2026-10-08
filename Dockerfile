FROM php:8.3-apache AS php-base

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libfreetype6-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libpq-dev \
        libzip-dev \
        util-linux \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        opcache \
        pdo_pgsql \
        zip \
    && a2enmod rewrite headers setenvif \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

FROM php-base AS dependencies

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . .

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --optimize-autoloader \
    --prefer-dist

FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json vite.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm install --no-audit --no-fund \
    && npm run build

FROM php-base AS runtime

ENV APP_ENV=production \
    APP_DEBUG=false \
    PORT=10000

COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf
COPY --from=dependencies /var/www/html /var/www/html
COPY --from=frontend /app/public/build /var/www/html/public/build
COPY docker/entrypoint.sh /usr/local/bin/apna-kisaan-entrypoint

RUN sed -i 's/^Listen 80$/Listen 10000/' /etc/apache2/ports.conf \
    && chmod +x /usr/local/bin/apna-kisaan-entrypoint \
    && mkdir -p \
        storage/app/private \
        storage/app/public \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
    && php artisan storage:link \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 10000

ENTRYPOINT ["apna-kisaan-entrypoint"]
CMD ["apache2-foreground"]
