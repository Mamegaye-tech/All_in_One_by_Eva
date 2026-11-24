
FROM php:8.4-apache

# Installer les dépendances système et PHP
RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libpng-dev \
    libjpeg62-turbo-dev libfreetype6-dev libonig-dev \
    libpq-dev nodejs npm \
    && docker-php-ext-install pdo pdo_mysql mbstring bcmath exif pcntl zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && a2enmod rewrite \
    && apt-get clean

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copier le projet
COPY . .

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Construire les fichiers CSS et JavaScript
RUN npm ci && npm run build

# Configurer Apache pour Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri 's!/var/www/!${APACHE_DOCUMENT_ROOT}/!g' /etc/apache2/apache2.conf

# Permissions Laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Port utilisé par Render
RUN sed -i 's/Listen 80/Listen 10000/' /etc/apache2/ports.conf \
    && sed -i 's/:80>/:10000>/' /etc/apache2/sites-available/000-default.conf

EXPOSE 10000

CMD ["apache2-foreground"]
