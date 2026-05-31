# Etapa 1: Construir los assets con Node
FROM node:18 AS build-frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install

COPY . .
RUN npm run build


# Etapa 2: Contenedor PHP + Apache
FROM php:8.2-apache

# Extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Carpeta de trabajo
WORKDIR /var/www/html

# Copiar todo el proyecto
COPY . /var/www/html

# Copiar los assets construidos
COPY --from=build-frontend /app/public/build /var/www/html/public/build

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Permisos
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Apache apunta a /public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]


