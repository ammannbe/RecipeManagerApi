# Cookbook

Homepage for Cookbooks

Written with laravel

# Deploy on Webserver with SSH access

## Clone Repo
### On new installation
```
git clone http://haumea.narrenhaus.local:3000/Narrenhaus/Cookbook.git
```

### Or on Update
```
git pull
```

## Setup .env file
- Edit `.env.example` to your needs
- Rename `.env.example` to `.env`

## Clear cache and Optimization
```
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
```

**If you have problems on login, try to remove the config cache:**
`php artisan config:clear`

## Update Database (on updates)
```
php artisan migrate
```

# Third-Party Tools
- [laravel-toast](https://github.com/Grimthorr/laravel-toast.git)
- [Parser](https://github.com/nathanmac/Parser.git)
