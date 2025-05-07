#!/bin/bash
# Direct PHP start script for debugging deployment issues

# Print environment info
echo "Starting direct PHP server..."
echo "Current directory: $(pwd)"
echo "Files in current directory:"
ls -la

# Create database directory if it doesn't exist
mkdir -p database
touch database/database.sqlite
chmod 777 database/database.sqlite

# Ensure storage permissions
chmod -R 777 storage
chmod -R 777 bootstrap/cache

# Clear Laravel cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Update .env if needed
if [ -f .env.production ]; then
  echo "Copying .env.production to .env"
  cp .env.production .env
fi

# Start the server
echo "Starting PHP built-in server on port 8080"
exec php artisan serve --host=0.0.0.0 --port=8080 