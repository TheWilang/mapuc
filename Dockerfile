FROM serversideup/php:8.2-fpm-nginx

USER root

RUN apt-get update && apt-get install -y nodejs npm

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www/html