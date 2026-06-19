#!/bin/sh

echo "Container starting..."

echo "Running database migrations..."
php artisan migrate --force

if [ $? -ne 0 ]; then
  echo "Migration failed. Stopping container."
  exit 1
fi

echo "Starting Laravel server..."
exec php artisan serve --host=0.0.0.0 --port=8000