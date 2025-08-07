#!/usr/bin/env bash
# Render start script for Laravel + React app

# Start the Laravel application using the built-in PHP server
# Render will provide the PORT environment variable
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
