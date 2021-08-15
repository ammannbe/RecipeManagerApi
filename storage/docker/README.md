# Quick reference

-   Issues: https://github.com/ammannbe/RecipeManagerApi
-   Supported architectures: amd64

# Available tags

-   8.x.x, 8.x, 8, latest
-   7.x.x, 7.x, 7
-   6.x.x, 6.x, 6

# Installation

It's recommended to install this application with docker.
Consult https://github.com/ammannbe/RecipeManagerDocker for installation

# Environement Variables

See also: [Laravel Configuration](https://laravel.com/docs/8.x/configuration)

## App specific

-   **APP_NAME:** Name of the App. _Default: RecipeManager_
-   **APP_ENV:** App environement. Possible values: "production", "local". _Default: local_
-   **APP_KEY:** Encryption key. This key will be set for you after the first startup.
-   **APP_DEBUG:** In production this value should be false. _Default: true_
-   **APP_URL:** The address, where the app should run. The port is optional. _Default: http://localhost:8000_
-   **SANCTUM_STATEFUL_DOMAINS** Your frontend domain (normally the Node.js docker container). _Default: localhost:3000_

## Locales

-   **LOCALE:** The default app locale _Default: en_
-   **LOCALES:** Possible locales. Leave empty to hide the language switcher in the UI. _Default: en,de_

## Logging

See also [Laravel Logging](https://laravel.com/docs/8.x/logging)

-   **LOG_CHANNEL:** Where should logs go. Possible values: stack, telegram, stderr _Default: stack_
-   **LOG_QUERIES:** Write every database query to the log file. This option enabled can blow up your log channel. _Default: false_
-   **TELEGRAM_LOGGER_BOT_TOKEN:** Only for **LOG_CHANNEL=telegram**. Also see [Telegram BotFather](https://core.telegram.org/bots#6-botfather).
-   **TELEGRAM_LOGGER_CHAT_ID:** Only for **LOG_CHANNEL=telegram**. Also see [Telegram BotFather](https://core.telegram.org/bots#6-botfather).

## Proxy

-   **TRUSTED_PROXIES** A comma separated list of IP Addresses of your proxies. _Default: 172.16.238.0/24_

## Database connections

See also [Laravel Database](https://laravel.com/docs/8.x/database#configuration)

-   **DB_CONNECTION:** Change the DBMS. _Default: mysql_
-   **DB_HOST:** Database host address. _Default: db_
-   **DB_PORT:** Database host port _Default: 3306_
-   **DB_DATABASE:** Table name _Default: recipe_manager_
-   **DB_USERNAME:** Username _Default: recipe_manager_
-   **DB_PASSWORD:** Provide a random string

## Redis cache

See also [Laravel Redis](https://laravel.com/docs/8.x/redis)

-   **REDIS_HOST:** Redis host address. _Default: redis_
-   **REDIS_PORT:** Redis host port _Default: 6379_
-   **REDIS_PASSWORD:** Provide a random string

## Full-text search

See also [Laravel Scout](https://laravel.com/docs/8.x/scout) and [Meilisearch](https://github.com/meilisearch/meilisearch-laravel-scout)

-   **SCOUT_DRIVER:** Scout Driver. _Default: meilisearch_
-   **MEILISEARCH_HOST:** MeiliSearch Host. _Default: http://meilisearch:7700_
-   **MEILISEARCH_KEY:** MeiliSearch Master Key

## Mail

See also [Laravel Mail](https://laravel.com/docs/8.x/mail)

-   **MAIL_MAILER:** Transport type _Default: smtp_
-   **MAIL_HOST:** Host address _Default: smtp.mailtrap.io_
-   **MAIL_PORT:** Host port _Default: 2525_
-   **MAIL_USERNAME:** E-Mail username _Default: null_
-   **MAIL_PASSWORD:** E-Mail username password _Default: null_
-   **MAIL_ENCRYPTION:** Encryption type, e.g. tls. _Default: null_
-   **MAIL_FROM_ADDRESS:** _Default: no-reply@recipe-manager.com_
-   **MAIL_FROM_NAME:** _Default: RecipeManager_

## Generic settings

-   **BROADCAST_DRIVER:** _Default: log_
-   **CACHE_DRIVER:** _Default: file_
-   **QUEUE_CONNECTION:** _Default: redis_
-   **SESSION_DRIVER:** _Default: cookie_
-   **SESSION_LIFETIME:** _Default: 120_
-   **SESSION_DOMAIN:** A TLD where the web and api have access to _Default: localhost_

## Optional features

-   **DISABLE_REGISTRATION** Disable user registrations _Default: false_
-   **DISABLE_COOKBOOKS** Disable the cookbooks feature _Default: false_
-   **DISABLE_TAGS** Disable the tags feature _Default: false_
-   **DISABLE_RATINGS** Disable the ratings feature _Default: false_
-   **DISABLE_FOOD_CREATION** Disable the food creation by normal users feature _Default: false_
-   **DISABLE_INGREDIENT_ATTRIBUTE_CREATION** Disable the ingredient attribute creation by normal users _Default: false_
-   **MAX_RATING_STARS** Tha amount of possible rating stars _Default: 5_
