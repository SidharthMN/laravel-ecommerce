#!/bin/sh
set -e

echo "[entrypoint] Starting Laravel container entrypoint"

# Install composer dependencies if `vendor` missing (safe-guard)
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
  echo "[entrypoint] Installing Composer dependencies (no-dev)..."
  composer install --no-dev --optimize-autoloader --no-interaction || true
fi

# Ensure .env exists
if [ ! -f .env ]; then
  echo "[entrypoint] .env not found, copying from .env.example"
  cp .env.example .env
fi

echo "[entrypoint] Running storage:link (if needed)"
php artisan storage:link || true

echo "[entrypoint] Clearing caches"
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Run migrations with retry loop to handle DB cold-starts
MAX_RETRIES=12
SLEEP_SECONDS=5
i=0
until [ $i -ge $MAX_RETRIES ]
do
  echo "[entrypoint] Attempting database migrations (try $((i+1))/$MAX_RETRIES)"
  if php artisan migrate --force; then
    echo "[entrypoint] Migrations completed"
    break
  fi
  i=$((i+1))
  echo "[entrypoint] Migrate failed, sleeping ${SLEEP_SECONDS}s"
  sleep ${SLEEP_SECONDS}
done

echo "[entrypoint] Fixing storage permissions"
chown -R www-data:www-data storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true

echo "[entrypoint] Bootstrap complete, executing CMD"
exec "$@"
