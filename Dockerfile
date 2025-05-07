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
RUN composer install --optimize-autoloader --no-scripts

# Copy package.json and build frontend assets first
COPY package.json package-lock.json ./
COPY vite.config.js postcss.config.js tailwind.config.js .nvmrc ./
RUN npm ci

# Copy server.js that was created
COPY server.js ./

# Copy env templates
COPY env.template ./
COPY env.production ./

# Copy rest of the application
COPY . .

# Create a proper .env file for production using our production template
RUN cp env.production .env
RUN echo "DB_DATABASE=/var/www/database/database.sqlite" >> .env

# Generate app key
RUN php artisan key:generate --force

# Prepare SQLite database file and ensure permissions
RUN mkdir -p database \
    && touch database/database.sqlite \
    && chmod 777 database/database.sqlite \
    && chown -R www-data:www-data database

# Run migrations to set up database schema
RUN php artisan migrate --force || true

# Create storage symlink & clear caches
RUN php artisan storage:link || true
RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear

# Build frontend assets with production settings
RUN npm run build

# Ensure the build directory exists in public
RUN mkdir -p public/build
# Copy build files to the public directory if they exist elsewhere
RUN cp -r public/build /var/www/public/ || true

# Set proper permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public
RUN find /var/www/storage -type d -exec chmod 755 {} \;
RUN find /var/www/storage -type f -exec chmod 644 {} \;
RUN chmod -R 777 /var/www/storage/logs
RUN chmod -R 777 /var/www/storage/framework
RUN chmod -R 777 /var/www/bootstrap/cache

# Expose port
EXPOSE 8080

# Use the Node.js server script which runs Laravel's PHP server
CMD ["node", "server.js"]
