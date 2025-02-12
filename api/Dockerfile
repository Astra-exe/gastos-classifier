# Usar la imagen oficial de PHP 8.2 con Apache
FROM php:8.2-apache

# Instalamos las dependencias necesarias para cURL y otras herramientas
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    git \
    unzip \
    --no-install-recommends \
    && docker-php-ext-install curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Configurar el puerto 8080 para el servidor web
EXPOSE 8080

# Habilitar la extensión CURL
RUN docker-php-ext-install curl

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Habilitar el módulo mod_rewrite de Apache
RUN a2enmod rewrite

# Configurar Apache para servir desde la carpeta "public/"
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Cambiar el puerto de Apache a 8080
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Copiar el código del proyecto al contenedor
COPY . /var/www/html/

# Instalar las dependencias de producción con Composer
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

# Reiniciar Apache para aplicar cambios
CMD apachectl -D FOREGROUND
