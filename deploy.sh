#!/bin/bash

echo "🚀 Starting deployment..."

# Save checksums of lock files before pulling
OLD_COMPOSER=$(md5sum composer.lock 2>/dev/null)
OLD_NPM=$(md5sum package-lock.json 2>/dev/null)

echo "📥 Pulling latest code..."
git pull

# Only install PHP deps if composer.lock changed
NEW_COMPOSER=$(md5sum composer.lock 2>/dev/null)
if [ "$OLD_COMPOSER" != "$NEW_COMPOSER" ]; then
    echo "📦 composer.lock changed — installing PHP dependencies..."
    composer install --no-dev --optimize-autoloader
else
    echo "✅ No PHP dependency changes, skipping composer install"
fi

# Only install Node deps if package-lock.json changed
NEW_NPM=$(md5sum package-lock.json 2>/dev/null)
if [ "$OLD_NPM" != "$NEW_NPM" ]; then
    echo "📦 package-lock.json changed — installing Node dependencies..."
    npm install
else
    echo "✅ No Node dependency changes, skipping npm install"
fi

echo "🔨 Building frontend assets..."
npm run build

echo "⚙️ Running database migrations..."
php artisan migrate --force

echo "🧹 Clearing caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Deployment complete!"
