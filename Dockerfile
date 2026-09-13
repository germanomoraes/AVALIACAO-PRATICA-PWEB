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

# Cria os diretórios persistentes usados pelo Laravel e o arquivo SQLite
RUN mkdir -p /var/www/database /var/www/storage/framework/sessions \
    /var/www/storage/framework/cache /var/www/storage/framework/views \
    && touch /var/www/database/database.sqlite
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/database
RUN chmod -R 777 /var/www/storage /var/www/database

# Garante o estado mínimo também quando o Render monta um volume sobre /var/www
CMD mkdir -p /var/www/database /var/www/storage/framework/sessions \
    /var/www/storage/framework/cache /var/www/storage/framework/views \
    && touch /var/www/database/database.sqlite \
    && php artisan config:clear \
    && php artisan migrate --force \
    && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}