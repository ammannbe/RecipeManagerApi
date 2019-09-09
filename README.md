# Cookbook

Application for recipes. Written with laravel.

Manage your families and friends recipes like a chef.

![Übersicht rezepte](https://klaud.narrenhaus.ch/index.php/s/8zNX4inf8xaRgD2/preview)

## Why is this so awesome?

- **Manager your recipes** You and your friends can save, edit and delete recipes.
- **Share recipes** You can share recipes by one click via Telegram or E-Mail.
- **Calculate yield amounts** Calculate yield amounts directly in the recipe on the fly.
- **Exactly define recipe properties** ..like author, category, tags, ingredients, units and more.

## Getting Started

Get the latest [release](https://git.narrenhaus.ch/Narrenhaus/Cookbook/releases) or clone the repo with

```bash
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
- Add following to your crontab:

```bash
  0  6  *  *  * www-data   cd /path-to-the-project && php artisan cleanup:all >> /dev/null 2>&1
```
- Run the server `php artisan serve`

## Deployment

- Install the software as described above (except running the server)
- Install composer packages `composer install --optimize-autoloader --no-dev`
- Enable caching:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**If you have problems on login, delete the cache (seems there's a bug somewhere in Adldap2):**

```bash
php artisan config:clear
```

## Update

- Get the latest source (see [Getting Started](#getting-started))
- Migrate the database `php artisan migrate`
- Install composer packages `composer install`
- Install NPM packages `npm install`

## Built With

* [Adldap2/Adldap2-Laravel](https://github.com/Adldap2/Adldap2-laravel) - LDAP Authentication & Management for Laravel
* [Askedio/laravel-soft-cascade](https://github.com/Askedio/laravel-soft-cascade) - Cascade Delete & Restore when using Laravel SoftDeletes
* [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar) - Laravel Debugbar (Integrates PHP Debug Bar)
* [benweet/stackedit.js](https://github.com/benweet/stackedit.js) - In-browser Markdown editor
* [doctrine/dbal](https://github.com/doctrine/dbal) - Doctrine Database Abstraction Layer
* [Grimthorr/laravel-toast](https://github.com/Grimthorr/laravel-toast) - Simple toast messages for Laravel 5
* [js-cookie/js-cookie](https://github.com/js-cookie/js-cookie) - A simple, lightweight JavaScript API for handling browser cookies
* [jquery/jquery](https://github.com/jquery/jquery) - jQuery JavaScript Library
* [jquery/jquery-ui](https://github.com/jquery/jquery-ui) - The official jQuery user interface library.
* [LaravelCollective/html](https://github.com/LaravelCollective/html) - HTML and Form Builders for the Laravel Framework
* [laravel/laravel](https://github.com/laravel/laravel) - A PHP framework for web artisans
* [nathanmac/Parser](https://github.com/nathanmac/Parser) - Simple PHP Parser Library for API Development
* [sass/sass](https://github.com/sass/sass) - Sass makes CSS fun!

## Authors

* **Benjamin Ammann** - *Initial work* - [ammannbe](https://github.com/ammannbe)

## License

This project is licensed under the AGPLv3 or later - see the [LICENSE](LICENSE) file for details


## Gallery

![Overview recipes](https://klaud.narrenhaus.ch/index.php/s/brXWi2Eg7ofK2e4/preview)
![Search recipe](https://klaud.narrenhaus.ch/index.php/s/KnoxBjsWaGT7T5w/preview)
![Zwiebel-Chutney](https://klaud.narrenhaus.ch/index.php/s/2cAXpKr2tobp7AN/preview)
