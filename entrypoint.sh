#!/usr/bin/env bash
set -euo pipefail
log() { printf '\e[32m[entrypoint]\e[0m %s\n' "$*"; }

APP_DIR=/var/www/html
cd "${APP_DIR}" || { echo "Cannot cd to ${APP_DIR}"; exit 1; }

# ── writable dirs ─────────────────────────────────────────────────────
log "Ensuring storage & cache exist"
mkdir -p storage/logs bootstrap/cache
touch    storage/logs/laravel.log

# ── APP_KEY ───────────────────────────────────────────────────────────
if [[ -f .env ]]; then
  if ! grep -qE '^APP_KEY=' .env || grep -qE '^APP_KEY=$' .env; then
    log "Generating APP_KEY"
    php artisan key:generate --quiet
  fi
else
  echo ".env not found – aborting."; exit 1
fi

# ── clear caches ──────────────────────────────────────────────────────
log "Clearing caches"
php artisan config:clear --quiet || true
php artisan cache:clear  --quiet || true
php artisan view:clear   --quiet || true
php artisan route:clear  --quiet || true

# ── migrate (optional seed) ───────────────────────────────────────────
log "Running migrations"
php artisan migrate --force --no-interaction
# php artisan db:seed --force --no-interaction

# ── symlink for storage ───────────────────────────────────────────────
php artisan storage:link

# ── rebuild caches ────────────────────────────────────────────────────
log "Caching config & routes"
php artisan config:cache --quiet
php artisan route:cache  --quiet
php artisan view:cache   --quiet

# ── start dev server (swap to php-fpm behind Nginx in prod) ───────────
log "Launching server on :${APP_PORT:-8000}"
exec php artisan serve --host=0.0.0.0 --port="${APP_PORT:-8000}"
