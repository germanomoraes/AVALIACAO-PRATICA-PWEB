FROM php:8.2-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip

# Instala extensões do PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copia os arquivos
COPY . .

# Instala as dependências (O erro que você teve foi aqui, faltou o install)
RUN composer install --no-dev --optimize-autoloader

# Permissões
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Exponha a porta 8000
EXPOSE 8000

# Comando para rodar o servidor interno do Laravel (mais fácil para deploy)
CMD php artisan serve --host=0.0.0.0 --port=8000