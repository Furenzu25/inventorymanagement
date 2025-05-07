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

# Copy package.json and build frontend assets first
COPY package.json package-lock.json ./
COPY vite.config.js postcss.config.js tailwind.config.js ./
RUN npm ci

# Copy rest of the application
COPY . .

# Set up environment with debug enabled to see error details
RUN cp -n .env.example .env 2>/dev/null || true
RUN sed -i 's/APP_DEBUG=false/APP_DEBUG=true/g' .env
RUN sed -i 's/APP_ENV=production/APP_ENV=development/g' .env
# Fix the APP_URL to use localhost during build
RUN sed -i 's#APP_URL=.*#APP_URL=http://localhost#g' .env
# Set explicit SQLite path
RUN echo "DB_CONNECTION=sqlite" >> .env
RUN echo "DB_DATABASE=/var/www/database/database.sqlite" >> .env
RUN php artisan key:generate --force

# Prepare SQLite database file and ensure permissions
RUN mkdir -p database \
    && touch database/database.sqlite \
    && chmod 777 database/database.sqlite \
    && chown -R www-data:www-data database

# Run migrations to set up database schema first
RUN php artisan migrate --force || true

# Create storage symlink & clear caches
RUN php artisan storage:link 2>/dev/null || true
RUN php artisan config:clear || true
RUN php artisan route:clear || true

# Build frontend assets
RUN npm run build

# Clear view cache safely
RUN php artisan view:clear || true
# Skip optimize:clear as it causes errors with SQLite
# RUN php artisan optimize:clear || true

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chown -R www-data:www-data /var/www/public

# Update permissions for all storage subdirectories
RUN find /var/www/storage -type d -exec chmod 755 {} \;
RUN find /var/www/storage -type f -exec chmod 644 {} \;
RUN chmod -R 777 /var/www/storage/logs
RUN chmod -R 777 /var/www/storage/framework
RUN chmod -R 777 /var/www/bootstrap/cache

# Expose port
EXPOSE 8080

# Run migrations at startup and serve application
CMD ["bash", "-lc", "php artisan migrate --force && php -d display_errors=1 -d display_startup_errors=1 artisan serve --host=0.0.0.0 --port=8080"]
