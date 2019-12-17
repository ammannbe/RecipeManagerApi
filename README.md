# RecipeManager

Api and Frontend to Manage your recipes. Written with Laravel and Vue.js.

Manage your families and friends recipes like a chef.

![Overview recipes](https://klaud.narrenhaus.ch/index.php/s/8zNX4inf8xaRgD2/preview)

## Why is this so awesome?

- **Manager your recipes** You and your friends can save, edit and delete recipes.
- **Share recipes** You can share recipes by one click via Telegram or E-Mail.
- **Calculate yield amounts** Calculate yield amounts directly in the recipe on the fly.
- **Exactly define recipe properties** ..like author, category, tags, ingredients, units and more.
- **Great and easy-to-use API** Access our easy-to-use REST-API.

## Getting Started

Get the latest [release](https://git.narrenhaus.ch/Narrenhaus/Cookbook/releases) or clone the repo with

```bash
git clone https://git.narrenhaus.ch/Narrenhaus/Cookbook.git
```

### Prerequisites

- LAMP Stack (only on production)
- Requirements for [laravel](https://laravel.com/docs)
- Composer
- NPM

### Installing

- Copy .env.example to .env and modify it to your needs
- Generate an app key `php artisan key:generate`
- Migrate the database `php artisan migrate`
- Generate JWT secret `php artisan jwt:secret`
- Install composer packages `composer install`
- Install NPM packages `npm install`
- Add following to your crontab:

```bash
  *  *  *  *  *  www-data   cd /path-to-the-project && php artisan schedule:run >> /dev/null 2>&1
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

## Update

- Get the latest source (see [Getting Started](#getting-started))
- Migrate the database `php artisan migrate`
- Install composer packages `composer install`
- Install NPM packages `npm install`

## Built With

* [Askedio/laravel-soft-cascade](https://github.com/Askedio/laravel-soft-cascade) - Cascade Delete & Restore when using Laravel SoftDeletes
* [laravel/laravel](https://github.com/laravel/laravel) - A PHP framework for web artisans
* [sass/sass](https://github.com/sass/sass) - Sass makes CSS fun!
* [vuejs/vue](https://github.com/vuejs/vue) - Vue.js is a progressive, incrementally-adoptable JavaScript framework for building UI on the web.
* [axios/axios](https://github.com/axios/axios) - Promise based HTTP client for the browser and node.js

## Authors

* **Benjamin Ammann** - *Initial work* - [ammannbe](https://github.com/ammannbe)

## License

This project is licensed under the AGPLv3 or later - see the [LICENSE](LICENSE) file for details

## Gallery

![Overview recipes](https://klaud.narrenhaus.ch/index.php/s/brXWi2Eg7ofK2e4/preview)
![Search recipe](https://klaud.narrenhaus.ch/index.php/s/KnoxBjsWaGT7T5w/preview)
![Zwiebel-Chutney](https://klaud.narrenhaus.ch/index.php/s/2cAXpKr2tobp7AN/preview)
