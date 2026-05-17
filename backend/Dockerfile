FROM php:8.2-fpm-alpine

RUN apk add --no-cache bash curl zip unzip git oniguruma-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring bcmath xml

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --prefer-dist

COPY . .
RUN composer dump-autoload --optimize \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8000
CMD ["sh", "-c", "composer install --no-scripts --prefer-dist && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"]
