FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update \
    && apt-get install -y \
        git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev \
        sqlite3 libsqlite3-dev nodejs npm \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
        pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy everything
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader --no-interaction

# Set proper permissions
RUN chmod -R 777 storage bootstrap/cache

# Create storage directories needed for product images
RUN mkdir -p storage/app/public/product-images
RUN chmod -R 777 storage/app

# Ensure SQLite database exists
RUN mkdir -p database
RUN touch database/database.sqlite
RUN chmod -R 777 database

# Create .env file with the correct values
RUN echo "APP_NAME=\"Rosels Trading\"" > .env
RUN echo "APP_ENV=production" >> .env
RUN echo "APP_DEBUG=false" >> .env
RUN echo "APP_URL=http://localhost" >> .env
RUN echo "DB_CONNECTION=sqlite" >> .env
RUN echo "DB_DATABASE=/var/www/database/database.sqlite" >> .env
RUN echo "BROADCAST_DRIVER=log" >> .env
RUN echo "CACHE_DRIVER=file" >> .env
RUN echo "QUEUE_CONNECTION=sync" >> .env
RUN echo "SESSION_DRIVER=file" >> .env
RUN echo "FILESYSTEM_DISK=local" >> .env

# Generate application key
RUN php artisan key:generate --force

# Link storage
RUN php artisan storage:link || echo "Storage link failed but continuing"

# Run migrations and seed database
RUN php artisan migrate:fresh --force
RUN php artisan db:seed --force

# Run Laravel optimization commands
RUN php artisan optimize
RUN php artisan config:cache
RUN php artisan event:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Generate assets
RUN npm install
RUN npm install -g vite
RUN chmod -R 777 node_modules/.bin/
RUN vite build

# Expose port
EXPOSE 8000

# Run PHP built-in server
CMD php artisan serve --host=0.0.0.0 --port=8000 