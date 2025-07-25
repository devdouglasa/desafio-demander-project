# Use uma imagem PHP-FPM como base
FROM php:8.2-fpm-alpine

# Definir o diretório de trabalho dentro do container
WORKDIR /var/www/html

# Instalar dependências do sistema e extensões PHP
# Adicionamos dependências para pdo_mysql, gd, zip, intl e bcmath, comuns em projetos Laravel
RUN apk add --no-cache \
    nginx \
    curl \
    libzip-dev \
    libpng-dev \
    jpeg-dev \
    git \
    supervisor \
    openssl-dev \
    postgresql-dev \
    mysql-client \
    mysql-dev \
    icu-dev \
    imagemagick-dev \
    sqlite-dev \
    libxml2-dev \
    oniguruma-dev \
    libcurl \
    libpq \
    libmcrypt-dev && \
    docker-php-ext-install pdo_mysql pdo_pgsql opcache bcmath exif pcntl gd zip intl soap sockets && \
    docker-php-ext-configure gd --with-jpeg --with-freetype && \
    docker-php-ext-install -j$(nproc) gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Limpar caches APK para reduzir o tamanho da imagem
RUN rm -rf /var/cache/apk/*

# Copiar os arquivos de configuração do Nginx e Supervisor
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf

# Expor a porta 9000 para FPM e 80 para Nginx
EXPOSE 9000
EXPOSE 80

# Copiar todo o código da aplicação para o diretório de trabalho
COPY . .

# Rodar composer install para instalar as dependências do Laravel
# --no-dev: Não instala dependências de desenvolvimento
# --optimize-autoloader: Otimiza o autoloader para produção
# --no-scripts: Não executa scripts definidos no composer.json (para evitar problemas durante a build, rode manualmente depois se necessário)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Otimizações para produção do Laravel
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Definir permissões adequadas para os diretórios 'storage' e 'bootstrap/cache'
# 'www-data' é o usuário padrão do Nginx/PHP-FPM na imagem Alpine
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Comando para iniciar o Supervisor, que gerenciará Nginx e PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]