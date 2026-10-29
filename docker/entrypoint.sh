#!/bin/sh
set -e

echo "🐑 Starting Kashmir Sheeps Production Environment..."

# Ensure SQLite database file exists if using sqlite
if [ "$DB_CONNECTION" = "sqlite" ] || [ -z "$DB_CONNECTION" ]; then
    DB_FILE="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
    mkdir -p "$(dirname "$DB_FILE")"
    if [ ! -f "$DB_FILE" ]; then
        echo "Creating SQLite database file at $DB_FILE..."
        touch "$DB_FILE"
        chown -R www-data:www-data "$(dirname "$DB_FILE")"
        chmod -R 775 "$(dirname "$DB_FILE")"
    fi
fi

# Run Database Migrations
echo "Running database migrations..."
php artisan migrate --force --isolated

# Run seeder if livestock_listings table is empty
COUNT=$(php artisan tinker --execute="echo App\Models\LivestockListing::count();" 2>/dev/null || echo "0")
if [ "$COUNT" = "0" ] || [ -z "$COUNT" ]; then
    echo "Database is empty. Seeding initial authentic Kashmir livestock listings..."
    php artisan db:seed --force
fi

# Cache configuration, routes, and views for lightning performance
echo "Optimizing Laravel for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Kashmir Sheeps is production ready and accepting traffic."

exec "$@"
