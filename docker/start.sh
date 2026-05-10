#!/bin/sh
set -e

cd /app

if [ -z "${DB_URL:-}" ]; then
    if [ -n "${DATABASE_URL:-}" ]; then
        export DB_URL="$DATABASE_URL"
    elif [ -n "${POSTGRES_URL:-}" ]; then
        export DB_URL="$POSTGRES_URL"
    elif [ -n "${MYSQL_URL:-}" ]; then
        export DB_URL="$MYSQL_URL"
    fi
fi

if [ -z "${DB_CONNECTION:-}" ]; then
    if [ -n "${PGHOST:-}" ] || [ -n "${POSTGRES_URL:-}" ]; then
        export DB_CONNECTION=pgsql
    elif [ -n "${MYSQLHOST:-}" ] || [ -n "${MYSQL_URL:-}" ]; then
        export DB_CONNECTION=mysql
    elif [ -n "${DB_URL:-}" ]; then
        case "$DB_URL" in
            postgres://*|postgresql://*) export DB_CONNECTION=pgsql ;;
            mysql://*|mariadb://*) export DB_CONNECTION=mysql ;;
        esac
    fi
fi

if [ "${DB_CONNECTION:-}" = "pgsql" ]; then
    export DB_HOST="${DB_HOST:-${PGHOST:-}}"
    export DB_PORT="${DB_PORT:-${PGPORT:-5432}}"
    export DB_DATABASE="${DB_DATABASE:-${PGDATABASE:-}}"
    export DB_USERNAME="${DB_USERNAME:-${PGUSER:-}}"
    export DB_PASSWORD="${DB_PASSWORD:-${PGPASSWORD:-}}"
elif [ "${DB_CONNECTION:-}" = "mysql" ]; then
    export DB_HOST="${DB_HOST:-${MYSQLHOST:-}}"
    export DB_PORT="${DB_PORT:-${MYSQLPORT:-3306}}"
    export DB_DATABASE="${DB_DATABASE:-${MYSQLDATABASE:-}}"
    export DB_USERNAME="${DB_USERNAME:-${MYSQLUSER:-}}"
    export DB_PASSWORD="${DB_PASSWORD:-${MYSQLPASSWORD:-}}"
fi

if [ -z "${DB_CONNECTION:-}" ]; then
    export DB_CONNECTION=sqlite
fi

if [ "$DB_CONNECTION" = "sqlite" ]; then
    export DB_DATABASE="${DB_DATABASE:-/app/database/database.sqlite}"
    mkdir -p "$(dirname "$DB_DATABASE")"
    touch "$DB_DATABASE"
fi

if [ -z "${APP_KEY:-}" ]; then
    echo "APP_KEY is missing. Generating a runtime key. Set APP_KEY in Railway Variables for a stable production key."
    unset APP_KEY
    if [ ! -f .env ]; then
        {
            echo "APP_NAME=\"${APP_NAME:-Preloved Market}\""
            echo "APP_ENV=${APP_ENV:-production}"
            echo "APP_DEBUG=${APP_DEBUG:-false}"
            echo "APP_URL=${APP_URL:-http://localhost}"
            echo "APP_KEY="
        } > .env
    elif ! grep -q '^APP_KEY=' .env; then
        echo "APP_KEY=" >> .env
    fi
    php artisan key:generate --force --no-interaction
fi

php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan storage:link --force || true
php artisan migrate --force --no-interaction

if [ "${SEED_SAMPLE_DATA:-true}" = "true" ]; then
    php artisan preloved:seed-samples --no-interaction
fi

php artisan config:cache
php artisan route:cache || true
php artisan view:cache

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
