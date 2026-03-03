FROM php:8.4-fpm

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev \
    libpq-dev libzip-dev zip unzip gnupg nginx \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs && apt-get clean

# Extensões PHP
RUN docker-php-ext-install \
    pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copia o projeto
COPY . .

# Instala dependências PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Instala dependências JS e faz o build
RUN npm install && npm run build

# Permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copia config do nginx
COPY docker/default.conf /etc/nginx/sites-available/default