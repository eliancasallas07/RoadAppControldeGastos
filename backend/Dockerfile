# Dockerfile para Symfony (PHP + Apache)
FROM php:8.2-apache

# Instala extensiones necesarias para Symfony y Composer (incluye pdo_pgsql para Postgres)
RUN apt-get update \
    && apt-get install -y libicu-dev git zip unzip libpq-dev libzip-dev \
    && docker-php-ext-install intl pdo pdo_pgsql pdo_mysql opcache zip

# Habilita mod_rewrite de Apache
RUN a2enmod rewrite

# Copia el código fuente
COPY . /var/www/html
WORKDIR /var/www/html

# Instala Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer


# Variables de entorno para producción
ENV APP_ENV=prod
ENV APP_DEBUG=0

# Instala dependencias de Symfony y limpia caché solo en prod
RUN composer install --no-interaction --optimize-autoloader --no-dev \
    && php bin/console cache:clear --env=prod --no-warmup || true

# Permisos para el cache y logs
RUN chown -R www-data:www-data var

# Expone el puerto 80
EXPOSE 80

# Listo para servir Symfony en http://localhost
