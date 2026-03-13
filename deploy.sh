#!/bin/bash

echo "🚀 Starting deployment..."

echo "📥 Pulling latest code..."
git pull

echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

echo "📦 Installing Node dependencies..."
npm install

echo "🔨 Building frontend assets..."
npm run build

echo "⚙️ Running database migrations..."
php artisan migrate --force

echo "🧹 Clearing caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Deployment complete!"
