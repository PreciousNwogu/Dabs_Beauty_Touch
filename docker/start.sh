#!/bin/bash
set -e

echo "🚀 Starting Dab's Beauty Touch application..."

# Wait for database to be ready
echo "⏳ Waiting for database connection..."
sleep 10

# Clear Laravel caches
echo "🧹 Clearing Laravel caches..."
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

# Seed services data (upsert — safe to run every deploy)
echo "🌱 Seeding services..."
php artisan db:seed --class=ServiceSeeder --force

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link

# Set final permissions
echo "🔒 Setting final permissions..."
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

echo "✅ Application setup complete! Starting Apache..."

# Run Laravel's scheduler every minute so appointment reminders go out
(while true; do
    php artisan schedule:run --no-interaction >> /var/www/html/storage/logs/scheduler.log 2>&1 || true
    sleep 60
done) &

# Start Apache in foreground
exec apache2-foreground
