# ======================================================
# Étape 1 : Build des assets Vite
# ======================================================
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

RUN npm run build

# ======================================================
# Étape 2 : PHP + Laravel
# ======================================================
FROM php:8.4-cli-alpine

# Dépendances système
RUN apk add --no-cache \
    git \
    unzip \
    zip \
    curl \
    libpq-dev \
    icu-dev \
    oniguruma-dev \
    libzip-dev

# Dépendances de compilation
RUN apk add --no-cache --virtual .build-deps \
    autoconf \
    g++ \
    make \
    linux-headers

# Extensions PHP
RUN docker-php-ext-configure intl && \
    docker-php-ext-install \
        intl \
        pdo_pgsql \
        bcmath \
        zip

# Redis (optionnel)
RUN pecl install redis && docker-php-ext-enable redis

# Nettoyage
RUN apk del .build-deps

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copie du projet
COPY . .

# Création du .env à partir du .env.example
RUN cp .env.example .env

# Installation des dépendances PHP
RUN composer install \
    --no-dev \
    --prefer-dist \
    --optimize-autoloader \
    --no-interaction

# Génération de la clé Laravel
RUN php artisan key:generate --force

# Copie des assets Vite compilés
COPY --from=frontend /app/public/build ./public/build

# Création des dossiers Laravel
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Permissions
RUN chmod -R 775 storage bootstrap/cache

# Storage link
RUN php artisan storage:link || true

EXPOSE 10000

# Pour le test local, on ne lance PAS les migrations
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
