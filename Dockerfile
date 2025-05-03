FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update \
    && apt-get install -y \
        git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev \
        sqlite3 libsqlite3-dev pkg-config nodejs npm \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
        pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files only and install PHP dependencies
COPY composer.json composer.lock ./
RUN composer install --optimize-autoloader --no-dev --no-scripts

# Copy rest of the application
COPY . .

# Prepare SQLite database file
RUN mkdir -p database \
    && touch database/database.sqlite \
    && chown -R www-data:www-data database

# Create storage symlink & clear config/view caches
RUN php artisan storage:link \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# Build frontend assets and clear caches again
RUN npm ci \
    && npm run build \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# Set permissions for storage and cache directories
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose application port
EXPOSE 8080

# Run migrations at startup and serve the app
CMD ["bash", "-lc", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8080"]
