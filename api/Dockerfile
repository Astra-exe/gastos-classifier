# Usamos la imagen oficial de PHP 8.2 con CLI como base
FROM php:8.2-cli

# Establecemos el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Instalamos dependencias necesarias para Composer
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_mysql

# Descargamos e instalamos Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiamos los archivos del proyecto al contenedor
COPY . .

# Ejecutamos "composer install --no-dev" para instalar las dependencias
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Exponemos el puerto 8000 para el servidor integrado de PHP
EXPOSE 8080

# Comando para iniciar el servidor integrado de PHP en la carpeta "public/"
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public/"]
