# Dockerfile

FROM php:8.2-fpm

# Instale dependências
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Instale Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crie diretório do app
WORKDIR /var/www

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Permissões
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

EXPOSE 9000

CMD ["php-fpm"]
