#!/bin/bash
set -e  # Exit immediately if a command exits with a non-zero status

echo "Starting build process..."

# Ensure database directory exists
mkdir -p database
touch database/database.sqlite
chmod 777 database/database.sqlite

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force || echo "Migration failed but continuing..."

# Link storage
echo "Linking storage..."
php artisan storage:link || echo "Storage link failed but continuing..."

# Clear existing caches first
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Cache configuration for production
echo "Caching configurations..."
php artisan config:cache || echo "Config cache failed but continuing..."
php artisan route:cache || echo "Route cache failed but continuing..."
php artisan view:cache || echo "View cache failed but continuing..."

# Build frontend assets if needed
if [ "$1" == "with-npm" ]; then
    echo "Building frontend assets..."
    npm run build
fi

echo "Build completed successfully!" 