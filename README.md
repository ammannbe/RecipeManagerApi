# Cookbook

Homepage for Cookbooks

# Deploy on i-MSCP

## Clone Repo
### On new installation
```
git clone http://haumea.narrenhaus.local:3000/Narrenhaus/Cookbook.git
```

### Or on Update
```
git pull
```

## Clear cache and Optimization
```
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
```

## Update Database (on updates)
```
php artisan migrate
```
