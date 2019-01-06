# Cookbook

Homepage for Cookbooks

# Deploy on i-MSCP

## Clone Repo
```
git pull http://haumea.narrenhaus.local:3000/Narrenhaus/Cookbook.git
```

## Clear cache and Optimization
```
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
```

## Migrate (on updates)
```
php artisan migrate
```