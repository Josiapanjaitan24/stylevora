FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    sqlite3 \
    libsqlite3-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy semua file project
COPY . .

# Install dependencies Laravel
RUN composer install --no-dev --optimize-autoloader

# Buat folder data untuk SQLite dan file database
RUN mkdir -p /var/data
COPY database/database.sqlite /var/data/database.sqlite
RUN chmod -R 775 /var/data storage bootstrap/cache

# Jangan generate APP_KEY di Dockerfile!
# Gunakan APP_KEY dari Railway Environment Variables

# Jalankan migration setelah deploy (tidak di build)
# RUN php artisan migrate --force

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000