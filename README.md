# RecipeManagerApi

Api backend to manage your recipes. Written with the PHP Framework [Laravel](https://laravel.com/).

A tool to manage your families and friends recipes like a chef.

![Recipes Overview](https://klaud.narrenhaus.ch/s/tSxqkHMpPgtPAGr/preview)

## Why is this so awesome?

-   **Manage your recipes** - You and your friends can save, edit and delete recipes.
-   **Share recipes** - You can share recipes by one click via Telegram or E-Mail.
-   **Calculate servings** - Calculate servings directly in the recipe on the fly.
-   **Exactly define recipe properties** - ..like author, category, tags, ingredients, units and more.
-   **Disable/Enable functionalities** - Disable or enable dynamically cookbooks, tags, registration and more.
-   **Great and easy API** - Access the easy-to-use REST-API.
-   **Strict or flexible item creation** - Disable/Enable the possibility for users to create own foods and ingredient attributes.

## What features are planned?

-   Unit and feature tests
-   Improve and add advanced searching and filtering
-   An advanced User-Role-System
-   Import & more export types of recipes
-   Nutrition informations
-   Rating system (the API code is already written ;-) )
-   Social login with Socialite
-   A feature you think is missing...

## Getting Started

Get the latest [release](https://github.com/ammannbe/RecipeManagerApi) or clone the repo with

```bash
git clone https://github.com/ammannbe/RecipeManagerApi.git
```

### Prerequisites

-   LAMP Stack or Docker for production use
-   Requirements for [laravel](https://laravel.com/docs)
-   GD and WebP for image manipulation
-   Composer
-   NPM
-   MeiliSearch
-   Redis (optional but not recommended)

### Installation

It's recommended to install and update this software with docker/docker-compose.
See [here](storage/docker/README.md) for more information.

Alternatively or for development purposes you can make a manual installation on any linux/unix machine:

#### Manual installation

-   Install composer packages `composer install`
-   Install NPM packages `npm install`
-   Copy .env.example to .env and modify it to your needs
-   Generate storage symlink `php artisan storage:link`
-   Generate an app key `php artisan key:generate`
-   Migrate the database `php artisan migrate`
-   Import meilisearch indexes `php artisan scout:index recipes && php artisan scout:import "App\Models\Recipes\Recipe"`
-   Add following to your crontab:

```bash
  *  *  *  *  *  www-data   cd /path-to-the-project && php artisan schedule:run >> /dev/null 2>&1
```

-   Run the server `php artisan serve`

#### Manual development deployment

-   If not already done, [install](#installation) everything
-   Run the server `php artisan serve`
-   Run the queue worker `php artisan queue:work`
-   Watch for style and js changes: `npm run watch`

#### Manual production deployment

-   If not already done, [install](#installation) everything
-   Optimize composer autoload `composer install --optimize-autoloader --no-dev`
-   Enable caching:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

-   Run the queue worker `php artisan queue:work` (or setup via e.g. systemd)
-   Optimize npm packages: `npm run prod`

## Update

-   Get the latest source (see [Getting Started](#getting-started))
-   Check `.env.example` for changes
-   Optimize composer autoload `composer install`
-   Install NPM packages `npm install`
-   Migrate the database `php artisan migrate`
-   Import meilisearch indexes `php artisan scout:index recipes && php artisan scout:import "App\Models\Recipes\Recipe"`
-   Follow [Development deployment](#development-deployment) or [Production deployment](#production-deployment)

## Translations

All application related files are translated with [laravel-translation-manager](https://github.com/barryvdh/laravel-translation-manager) and [laravel-translations-loader](https://github.com/kirschbaum-development/laravel-translations-loader).

You should run these commands only on a development machine.

You need to run the migrations for this package:

```bash
php artisan vendor:publish --provider="Barryvdh\TranslationManager\ManagerServiceProvider" --tag=migrations
php artisan migrate
```

-   Import translations `composer run translations:import`
-   Open `<your-domain>/translations` in a browser
-   PHP: short keys within `resources/lang/<lang>/<group>.php`
-   Vue.js: translation strings within `/resources/lang/<lang>.json` (these files will be imported into the `_json` group)
-   Export & generate translations `composer run translations:export`

Other commands:

-   Export translations `php artisan translations:export \*`
-   Reset translations `php artisan translations:reset`

## IDE helpers

You get better IDE IntelliSense support with the [laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper) package.

You need to generate the helpers by yourself:

```bash
composer run ide-helper:generate
```

After that, you should run the commands from [Testing / Code Quality](#testing-/-code-quality).

## Testing / Code Quality

-   Optional: seed the database with test data

```bash
# Seed the database with test data
php artisan db:seed

# Freshly migrate and seed the database
php artisan migrate:fresh --seed

# The secret of the seeded users is 'password'
```

-   Run static code analytics `composer run phpstan`
-   Run PHP Coding Standards Fixer `composer run php-cs-fixer`

## Built With

-   [Askedio/laravel-soft-cascade](https://github.com/Askedio/laravel-soft-cascade) - Cascade Delete & Restore when using Laravel SoftDeletes
-   [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf) - A DOMPDF Wrapper for Laravel
-   [GrKamil/laravel-telegram-logging](https://github.com/GrKamil/laravel-telegram-logging) - Send logs to Telegram chat via Telegram bot
-   [laravel/laravel](https://github.com/laravel/laravel) - A PHP framework for web artisans
-   [meilisearch/meilisearch-laravel-scout](https://github.com/meilisearch/meilisearch-laravel-scout) - Laravel Scout Engine for Meilisearch
-   [rutorika/sortable](https://github.com/boxfrommars/rutorika-sortable) - Adds sortable behavior to Laravel Eloquent models
-   [spatie/laravel-medialibrary](https://github.com/spatie/laravel-medialibrary) - Associate files with Eloquent models

-   [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper) - Laravel IDE Helper
-   [barryvdh/laravel-translation-manager](https://github.com/barryvdh/laravel-translation-manager) - Manage Laravel translation files
-   [nunomaduro/larastan](https://github.com/nunomaduro/larastan) - Adds static analysis to Laravel improving developer productivity and code quality
-   [stechstudio/Laravel-PHP-CS-Fixer](https://github.com/stechstudio/Laravel-PHP-CS-Fixer) - Artisan Command for FriendsOfPHP/PHP-CS_Fixer

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Authors

-   **Benjamin Ammann** - _Initial work_ - [ammannbe](https://github.com/ammannbe)

## License

This project is licensed under the AGPLv3 or later - see the [LICENSE](LICENSE) file for details

## Gallery

|                                                                                     |                                                                           |                                                                            |
| ----------------------------------------------------------------------------------- | ------------------------------------------------------------------------- | -------------------------------------------------------------------------- |
| ![Recipes Overview - Mobile](https://klaud.narrenhaus.ch/s/R6fWdPGMytSxR54/preview) | ![Recipe - Mobile](https://klaud.narrenhaus.ch/s/obLXYzPMzqfPCCN/preview) | ![Account - Mobile](https://klaud.narrenhaus.ch/s/i8jjnnc6YMtRLrw/preview) |
