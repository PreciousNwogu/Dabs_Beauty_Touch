#!/usr/bin/env bash
# Render build script for Laravel + React app

set -o errexit

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node.js dependencies
npm ci

# Build frontend assets
npm run build

# Clear and cache Laravel configurations
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Generate optimized configuration cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
php artisan migrate --force

#!/usr/bin/env bash
# Render build script for Laravel + React app

set -o errexit

echo "🚀 Starting build process..."

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

# Install Node.js dependencies
echo "📦 Installing Node.js dependencies..."
npm ci

# Build frontend assets
echo "🏗️ Building frontend assets..."
npm run build

# Generate application key if not set
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# Create storage directories
echo "📁 Setting up storage..."
mkdir -p storage/app/public/sample_pictures
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs

# Set proper permissions
chmod -R 775 storage bootstrap/cache

# Clear and cache Laravel configurations
echo "🧹 Clearing Laravel cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Cache configurations for production
echo "⚡ Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
echo "🗃️ Running database migrations..."
php artisan migrate --force

# Link storage
echo "🔗 Linking storage..."
php artisan storage:link

echo "✅ Build completed successfully!"

# Set proper permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
