FROM php:8.2-cli

# Instala dependências do sistema, driver do SQLite e Node.js (Vite)
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    sqlite3 libsqlite3-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Instala extensões do PHP
RUN docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

# Instala dependências PHP e JS, e compila o Vite
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Cria a pasta database e o arquivo SQLite com permissão de escrita
RUN mkdir -p /var/www/database && touch /var/www/database/database.sqlite
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/database
RUN chmod -R 777 /var/www/storage /var/www/database

# Script de inicialização: roda as migrations e sobe o servidor
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}