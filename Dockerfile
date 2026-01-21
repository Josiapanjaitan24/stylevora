# Gunakan PHP CLI versi 8.2
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

# Buat file database.sqlite jika belum ada
RUN mkdir -p database && touch database/database.sqlite

# Set permission folder penting
RUN chmod -R 775 storage bootstrap/cache database

# Generate APP_KEY
RUN php artisan key:generate --force

# Jalankan migration agar tabel dibuat otomatis
RUN php artisan migrate --force

# Expose port Laravel
EXPOSE 10000

# Jalankan server Laravel
CMD php artisan serve --host=0.0.0.0 --port=10000