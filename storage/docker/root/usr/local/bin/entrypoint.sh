#!/usr/bin/env bash

set -e

# Get the container role "app", "scheduler", "queue"
role=${CONTAINER_ROLE:-app}

# Make sure we have the correct directory permissions
chown -R www-data:www-data /var/www/html/storage/app

if [[ "$role" == "app" ]]; then
    # Generate required symlink
    sudo -u www-data php artisan storage:link

    # Generate the app key (if not already done)
    sudo -u www-data php artisan key:generate --no-interaction

    # Cache config, routes and views
    sudo -u www-data php artisan config:cache
    sudo -u www-data php artisan route:cache
    sudo -u www-data php artisan view:cache

    # Compile JS/CSS
    sudo -u www-data npm run prod

    echo "Wait 30s until external services are up and running"
    sleep 30

    # Import meilisearch indexes
    sudo -u www-data php artisan scout:index recipes
    sudo -u www-data php artisan scout:import "App\Models\Recipes\Recipe"

    # Migrate Database
    sudo -u www-data php artisan migrate --force

    # Start Apache
    exec apache2-foreground
elif [[ "$role" == "scheduler" ]]; then
    sleep 300
    echo "Running the scheduler..."
    while [ true ]; do
        sudo -u www-data php artisan schedule:run --no-interaction &
        sleep 60
    done
elif [[ "$role" == "queue" ]]; then
    sleep 300
    echo "Running the queue..."
    sudo -u www-data php artisan queue:work
else
    echo "Could not match the container role \"$role\""
    exit 1
fi
