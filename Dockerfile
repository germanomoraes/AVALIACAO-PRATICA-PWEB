FROM php:8.2-fpm

# Instala dependências do sistema, driver do SQLite e Node.js (Vite)
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    sqlite3 libsqlite3-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Instala extensões do PHP (incluindo pdo_sqlite e sqlite3)
RUN docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

# Cria o arquivo de banco SQLite prévio dentro do container
RUN touch /var/www/database/database.sqlite

# Instala dependências PHP e JS, e compila o Vite
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Ajusta permissões para as pastas de armazenamento e banco de dados
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/database

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000