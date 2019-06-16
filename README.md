# Cookbook

Application for recipes. Written with laravel.

## Getting Started

Get the latest [release](https://git.narrenhaus.ch/Narrenhaus/Cookbook/releases) or clone the repo with
```
git clone https://git.narrenhaus.ch/Narrenhaus/Cookbook.git
```

### Prerequisites

- LAMP Stack (only on production)
- Requirements for [laravel](https://laravel.com/docs)
- LDAP Server
- Composer
- NPM

### Installing

- Copy .env.example to .env and modify it to your needs
- Generate an app key `php artisan key:generate`
- Migrate the database `php artisan migrate`
- Install composer packages `composer install`
- Install NPM packages `npm install`
- Run the server `php artisan serve`

## Deployment

- Install the software as above described (except running the server)
- Optimize autoloader `composer install --optimize-autoloader --no-dev`
- Enable caching
```
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
**If you have problems on login, try to remove the config cache:** `php artisan config:clear`

## Update

- Get the latest source (see [Getting Started](#getting-started))
- Migrate the database `php artisan migrate`
- Install composer packages `composer install`
- Install NPM packages `npm install`

## Built With

* [laravel/laravel](https://github.com/laravel/laravel) - A PHP framework for web artisans
* [LaravelCollective/html](https://github.com/LaravelCollective/html) - HTML and Form Builders for the Laravel Framework
* [Grimthorr/laravel-toast](https://github.com/Grimthorr/laravel-toast) - Simple toast messages for Laravel 5
* [nathanmac/Parser](https://github.com/nathanmac/Parser) - Simple PHP Parser Library for API Development
* [Adldap2/Adldap2-Laravel](https://github.com/Adldap2/Adldap2-laravel) - LDAP Authentication & Management for Laravel
* [doctrine/dbal](https://github.com/doctrine/dbal) - Doctrine Database Abstraction Layer
* [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar) - Laravel Debugbar (Integrates PHP Debug Bar)
* [sass/sass](https://github.com/sass/sass) - Sass makes CSS fun!
* [jquery/jquery](https://github.com/jquery/jquery) - jQuery JavaScript Library
* [jquery/jquery-ui](https://github.com/jquery/jquery-ui) - The official jQuery user interface library.
* [js-cookie/js-cookie](https://github.com/js-cookie/js-cookie) - A simple, lightweight JavaScript API for handling browser cookies

## Authors

* **Benjamin Ammann** - *Initial work* - [ammannbe](https://github.com/ammannbe)

## License

This project is licensed under the AGPLv3 or later - see the [LICENSE](LICENSE) file for details
