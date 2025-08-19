FROM php:8.2-fpm

# Argumentos
ARG user=www-data
ARG uid=1000

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
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
    && pecl install imagick \
    && docker-php-ext-enable imagick

# Limpiar caché
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp --with-xpm
RUN docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip \
    opcache

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuración de PHP
COPY docker/php/php.ini /usr/local/etc/php/conf.d/app.ini

# Crear usuario para ejecutar comandos de Composer y Artisan
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Establecer directorio de trabajo
WORKDIR /var/www

# Copiar archivos de la aplicación
COPY --chown=$user:www-data . /var/www

# Configurar permisos
RUN chown -R $user:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Instalar dependencias
USER $user
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Generar clave de la aplicación
RUN php artisan key:generate

# Usuario para ejecutar los comandos
USER root

# Puerto expuesto
EXPOSE 9000

# Comando de inicio
CMD ["php-fpm"]
