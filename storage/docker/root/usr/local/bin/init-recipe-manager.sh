#!/usr/bin/env bash

# Cache config, routes and views
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Compile JS/CSS
npm run prod

# Migrate Database
php artisan migrate

exec apache2-foreground
