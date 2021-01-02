#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}

if [[ "$role" == "app" ]]; then
    # Cache config, routes and views
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

    # Compile JS/CSS
    npm run prod

    # Migrate Database
    php artisan migrate

    # Start Apache
    exec apache2-foreground
elif [[ "$role" == "scheduler" ]]; then
    echo "Running the scheduler..."
    while [ true ]; do
        php /var/www/html/artisan schedule:run --verbose --no-interaction &
        sleep 60
    done
elif [[ "$role" == "queue" ]]; then
    echo "Running the queue..."
    php /var/www/html/artisan queue:work --verbose
else
    echo "Could not match the container role \"$role\""
    exit 1
fi
