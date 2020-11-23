#!/usr/bin/env bash

# Migrate Database
php artisan migrate

# Cache config, routes and views
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Compile JS/CSS
npm run prod

exec apache2-foreground
