FROM php:8.2-fpm

# Install system dependencies
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get update \
    && apt-get install -y \
        git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev \
        sqlite3 libsqlite3-dev nodejs \
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

RUN cp .env.example .env \
 && sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env \
 && sed -i 's/^DB_DATABASE=.*/DB_DATABASE=\/var\/www\/database\/database.sqlite/' .env

# Install dependencies
RUN composer install --optimize-autoloader --no-interaction

# Set proper permissions
RUN chmod -R 777 storage bootstrap/cache

# Create storage directories needed for product images
RUN mkdir -p /var/data/uploads
RUN chmod -R 777 storage/app

# Ensure SQLite database exists
RUN mkdir -p database
RUN touch database/database.sqlite
RUN chmod -R 777 database

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
RUN chmod -R 777 node_modules/.bin/
RUN npm run build

# Link public storage
RUN ln -sfn /var/data/uploads storage/app/public

# Clear all caches before serving (bust cache)
RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear
RUN php artisan cache:clear

# Expose port
EXPOSE ${PORT:-8000}

# Run PHP built-in server with environment PORT variable
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}