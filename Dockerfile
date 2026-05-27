FROM dunglas/frankenphp:latest as app

RUN install-php-extensions \
    pdo_mysql \
    mbstring \
    bcmath \
    zip \
    intl \
    opcache \
    gd

COPY production.ini /usr/local/etc/php/conf.d/99-custom.ini

WORKDIR /app

COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data storage bootstrap/cache public

EXPOSE 80

COPY Caddyfile /etc/caddy/Caddyfile

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
