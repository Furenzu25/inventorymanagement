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

# Copy composer files only and install dependencies
COPY composer.json composer.lock ./
RUN composer install --optimize-autoloader --no-dev --no-scripts

# Copy rest of the application
COPY . .

# Set up environment
RUN cp -n .env.example .env 2>/dev/null || true
RUN php artisan key:generate --force

# Prepare SQLite database file
RUN mkdir -p database \
    && touch database/database.sqlite \
    && chown -R www-data:www-data database

# Run migrations to set up database schema first
RUN php artisan migrate --force || true

# Create storage symlink & clear caches
RUN php artisan storage:link 2>/dev/null || true
RUN php artisan config:clear || true
RUN php artisan route:clear || true

# Build frontend assets
RUN npm ci && npm run build

# Clear view cache safely
RUN php artisan view:clear || true
# Skip optimize:clear as it causes errors with SQLite
# RUN php artisan optimize:clear || true

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose port
EXPOSE 8080

# Run migrations at startup and serve application
CMD ["bash", "-lc", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8080"]
