#!/bin/bash

# Navigate to the application directory
echo "Navigating to /var/www/html..."
cd /var/www/html || { echo "Failed to navigate to /var/www/html. Exiting."; exit 1; }

# Check if the .env file exists and if the APP_KEY is set
if [ -f ".env" ]; then
    if ! grep -q "APP_KEY=base64" .env; then
        # Generate the application key
        echo "Generating application key..."
        php artisan key:generate
    fi
else
    echo ".env file not found. Please make sure the .env file exists."
    exit 1
fi


# Clear caches before running migration
echo "Clearing Laravel config and caches before migration..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Run migration with detailed output
echo "Running migrations..."
php artisan migrate

# Run seeders
echo "Running seeders..."

# Create storage symlink
echo "Creating storage symlink..."
php artisan storage:link

# Publish log viewer
echo "Publishing log viewer..."
php artisan log-viewer:publish

# Clear Laravel caches again
echo "Clearing Laravel config and caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Start Laravel's built-in development server on port 8000
echo "Starting Laravel development server..."
php artisan serve --host=0.0.0.0 --port=8000
