# Etapa de construcción para assets
FROM node:18-alpine as build
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY resources/ ./resources/
COPY vite.config.js ./
RUN npm run build

# Etapa de producción
FROM php:8.2-fpm-alpine

# Instalar dependencias del sistema
RUN apk add --no-cache \
    libzip-dev \
    oniguruma-dev \
    nginx \
    supervisor \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        zip \
        opcache \
    && docker-php-ext-enable opcache

# Instalar Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www

# Copiar solo los archivos necesarios
COPY . .
COPY --from=build /app/public/build /var/www/public/build

# Instalar dependencias de PHP y optimizar
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Configuración de Nginx
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Configuración de Supervisor
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Establecer permisos
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache \
    && php artisan storage:link

# Puerto expuesto
EXPOSE 80

# Comando de inicio
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
