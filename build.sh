#!/bin/bash

# Run database migrations
php artisan migrate --force

# Link storage
php artisan storage:link

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Build completed successfully!" 