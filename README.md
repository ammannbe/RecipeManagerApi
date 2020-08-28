# RecipeManager

Api and Frontend to Manage your recipes. Written with Laravel and Vue.js.

Manage your families and friends recipes like a chef.

---

### **_Comming from an older version? Check out the migration guide from the 5.x branch._**

---

![Recipes Overview](https://klaud.narrenhaus.ch/index.php/s/MRNc7KsMbcAFnkn/preview)

## Why is this so awesome?

-   **Manager your recipes** You and your friends can save, edit and delete recipes.
-   **Share recipes** You can share recipes by one click via Telegram or E-Mail.
-   **Calculate yield amounts** Calculate yield amounts directly in the recipe on the fly.
-   **Exactly define recipe properties** ..like author, category, tags, ingredients, units and more.
-   **Disable/Enable functionalities** Disable or enable dynamically cookbooks and/or tags.
-   **Great and easy API** Access the easy-to-use REST-API.

## What features are planned?

-   Unit and feature tests
-   Better support for editing and deleting cookbooks, recipes, ingredients, etc.
-   Better support for photos (creating thumbnails, convert them to WEBP, allow cropping)
-   Improve and add advanced searching and filtering
-   An installer
-   An advanced User-Role-System
-   WebSockets
-   Import & Export of recipes
-   Nutrition informations
-   Rating system (the API code is already written ;-) )
-   And a lot more...

## Getting Started

Get the latest [release](https://git.narrenhaus.ch/Narrenhaus/Cookbook/releases) or clone the repo with

```bash
git clone https://git.narrenhaus.ch/Narrenhaus/Cookbook.git
```

### Prerequisites

-   LAMP Stack (only on production)
-   Requirements for [laravel](https://laravel.com/docs)
-   Composer
-   NPM

### Installation

It's recommended to install and update this software with docker/docker-compose.
See [here](docker/README.md) for more information.

Alternatively or for development purposes you can make a manual installation on any linux/unix machine:

#### Manual installation

-   Install composer packages `composer install`
-   Install NPM packages `npm install`
-   Copy .env.example to .env and modify it to your needs
-   Generate an app key `php artisan key:generate`
-   Migrate the database `php artisan migrate`
-   Add following to your crontab:

```bash
  *  *  *  *  *  www-data   cd /path-to-the-project && php artisan schedule:run >> /dev/null 2>&1
```

-   Run the server `php artisan serve`

#### Manual development deployment

-   If not already done, [install](#installation) everything
-   Run the server `php artisan serve`
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

-   Optimize npm packages: `npm run prod`

## Update

-   Get the latest source (see [Getting Started](#getting-started))
-   Check `.env.examples` for changes
-   Optimize composer autoload `composer install`
-   Install NPM packages `npm install`
-   Migrate the database `php artisan migrate`
-   Follow [Development deployment](#development-deployment) or [Production deployment](#production-deployment)

## Translations

All application related files are translated with [laravel-translation-manager](https://github.com/barryvdh/laravel-translation-manager) and [laravel-vue-i18n-generator](https://github.com/martinlindhe/laravel-vue-i18n-generator).
Translations should only be done on development.

You need to run the migrations for this package:

```bash
php artisan vendor:publish --provider="Barryvdh\TranslationManager\ManagerServiceProvider" --tag=migrations
php artisan migrate
```

-   Import translations `composer translations:import`
-   Navigate to `<your-domain>/translations` for translation
-   PHP: short keys within `resources/lang/<lang>/<group>.php`
-   Vue.js: translation strings within `/resources/lang/<lang>.json` (these files will be imported into the `_json` group)
-   Export & generate translations `composer translations:export`

Don't forget to run `composer php-cs-fixer`

Other commands:

-   Export translations `php artisan translations:export \*`
-   Reset translations `php artisan translations:reset`
-   Generate ES6 file for Vue.js `php artisan vue-i18n:generate`

## Testing / Code Quality

-   Run static code analytics `composer phpstan`
-   Run PHP Coding Standards Fixer `composer php-cs-fixer`

## Built With

-   [laravel/laravel](https://github.com/laravel/laravel) - A PHP framework for web artisans
-   [Askedio/laravel-soft-cascade](https://github.com/Askedio/laravel-soft-cascade) - Cascade Delete & Restore when using Laravel SoftDeletes
-   [rutorika/sortable](https://github.com/boxfrommars/rutorika-sortable) - Adds sortable behavior to Laravel Eloquent models
-   [GrKamil/laravel-telegram-logging](https://github.com/GrKamil/laravel-telegram-logging) - Send logs to Telegram chat via Telegram bot
-   [nunomaduro/larastan](https://github.com/nunomaduro/larastan) - Adds static analysis to Laravel improving developer productivity and code quality
-   [stechstudio/Laravel-PHP-CS-Fixer](https://github.com/stechstudio/Laravel-PHP-CS-Fixer) - Artisan Command for FriendsOfPHP/PHP-CS_Fixe
-   [barryvdh/laravel-translation-manager](https://github.com/barryvdh/laravel-translation-manager) - Manage Laravel translation files
-   [martinlindhe/laravel-vue-i18n-generator](https://github.com/martinlindhe/laravel-vue-i18n-generator) - Generates a vue-i18n compatible include file from your Laravel translations
-   [sass/sass](https://github.com/sass/sass) - Sass makes CSS fun!
-   [vuejs/vue](https://github.com/vuejs/vue) - Vue.js is a progressive, incrementally-adoptable JavaScript framework for building UI on the web.
-   [axios/axios](https://github.com/axios/axios) - Promise based HTTP client for the browser and node.js
-   [SortableJS/Vue.Draggable](https://github.com/SortableJS/Vue.Draggable) - Vue drag-and-drop component based on Sortable.js
-   [PeachScript/vue-infinite-loading](https://github.com/PeachScript/vue-infinite-loading) - An infinite scroll plugin for Vue.js.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Authors

-   **Benjamin Ammann** - _Initial work_ - [ammannbe](https://github.com/ammannbe)

## License

This project is licensed under the AGPLv3 or later - see the [LICENSE](LICENSE) file for details

## Gallery

|                                                                                               |                                                                                      |                                                                                     |
| --------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------ | ----------------------------------------------------------------------------------- |
| ![Recipes Overview - Mobile](https://klaud.narrenhaus.ch/index.php/s/mgasnaoeXWMQttc/preview) | ![Account - Mobile](https://klaud.narrenhaus.ch/index.php/s/6QXbsZymS2econD/preview) | ![Recipe - Mobile](https://klaud.narrenhaus.ch/index.php/s/dq44kfHykxs9AZx/preview) |
