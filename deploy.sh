#!/usr/bin/env bash
set -e

echo "🚀 Deploying Kashmir Sheeps Marketplace to Production..."

# 1. Put application into maintenance mode with 15s retry header
php artisan down --retry=15 --secret="kashmir-deploy-bypass" || true

# 2. Pull latest code (if using git)
# git pull origin main

# 3. Install/update Composer dependencies (no dev, optimized)
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# 4. Run database migrations
php artisan migrate --force --isolated

# 5. Clear and rebuild Laravel production caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 6. Restart queue workers (if any)
php artisan queue:restart || true

# 7. Bring application out of maintenance mode
php artisan up

# 8. Check health endpoint
HEALTH_STATUS=$(curl -s -o /dev/null -w "%{http_code}" http://127.0.0.1:8000/health || echo "000")

if [ "$HEALTH_STATUS" = "200" ]; then
    echo "✅ Deployment successful! System health is 200 OK."
else
    echo "⚠️ Warning: Health check returned HTTP status $HEALTH_STATUS. Check storage/logs/laravel.log."
fi
