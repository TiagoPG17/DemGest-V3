FROM php:8.2-fpm

# Argumentos
ARG user=www-data
ARG uid=1000

# Variables de entorno
ENV NODE_VERSION=18.x
ENV COMPOSER_VERSION=2.7.1

# Instalar dependencias del sistema y extensiones PHP en una sola capa
RUN set -eux; \
    # Instalar dependencias del sistema
    apt-get update && apt-get install -y --no-install-recommends \
        git \
        curl \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
        libzip-dev \
        libicu-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libwebp-dev \
        libxpm-dev \
        libmagickwand-dev \
        libgd-dev \
    # Instalar Node.js
    && curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION} | bash - \
    && apt-get install -y nodejs \
    # Instalar extensiones PHP
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp --with-xpm \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        intl \
        zip \
        opcache \
    # Instalar imagick
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    # Limpiar cache
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && npm cache clean --force

# Instalar Composer
COPY --from=composer:${COMPOSER_VERSION} /usr/bin/composer /usr/bin/composer

# Configuración PHP
COPY docker/php/php.ini /usr/local/etc/php/conf.d/app.ini

# Establecer el directorio de trabajo
WORKDIR /var/www

# Copiar solo los archivos necesarios primero para aprovechar la caché de Docker
COPY composer.* package*.json ./

# Instalar dependencias PHP
RUN composer install --no-interaction --optimize-autoloader --no-dev \
    && composer clear-cache

# Copiar el resto de la aplicación
COPY . .

# Instalar dependencias Node, compilar assets y limpiar caché
RUN npm ci --only=production \
    && npm run build \
    && npm cache clean --force

# Configurar permisos
RUN chown -R www-data:www-data /var/www \
    && find /var/www -type d -exec chmod 755 {} \; \
    && find /var/www -type f -exec chmod 644 {} \; \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Configuración de seguridad adicional
RUN echo "expose_php = Off" >> /usr/local/etc/php/conf.d/security.ini \
    && echo "display_errors = Off" >> /usr/local/etc/php/conf.d/security.ini \
    && echo "log_errors = On" >> /usr/local/etc/php/conf.d/security.ini

# Puerto expuesto
EXPOSE 9000

# Comando de inicio
CMD ["php-fpm"]
