# Quick reference

-   Issues: https://github.com/ammannbe/RecipeManager
-   Supported architectures: amd64

# Available tags

-   8.x.x, 8.x, 8, latest
-   7.x.x, 7.x, 7
-   6.x.x, 6.x, 6

# Installation

It's recommended to install this application with docker-compose:

-   Create a new directory, e.g. in /opt: `mkdir /opt/recipe-manager`
-   Switch to the newly created directory: `cd /opt/recipe-manager`
-   Download the .env.example and edit it to your needs (see [Environement Variables](environement-variables)):

```bash
wget https://github.com/ammannbe/RecipeManager/blob/7.x/storage/docker/.env.example -O .env
nano .env
```

-   IMPORTANT: make sure that you changed the `APP_ENV` to `production`
-   Download the exmaple docker-compose.yml and edit it to your needs:

```bash
wget https://github.com/ammannbe/RecipeManager/blob/7.x/storage/docker/docker-compose.yml
nano docker-compose.yml
```

-   Optional automatically start the container after system boot:
-   Copy or symlink the [recipe-manager.service](recipe-manager.service) service file to `/etc/systemd/system/recipe-manager.service`.
-   Enable the service: `systemctl enable recipe-manager.service`
-   Start the service: `systemctl start recipe-manager.service`

# Files you can overwrite

With the _volumes:_ option you can overwrite every file/folder from the containers.

Example:

```bash
services:
  app:

    ...

    volumes:
      - ./html:/var/www/html
      - ./data/app:/var/www/html/storage/app
      - ./data/mysql:/var/lib/mysql
      - ./data/meilisearch:/data.ms
      - ./favicon.ico:/var/www/html/public/favicon.ico
      - ./entrypoint.sh:/usr/local/bin/entrypoint.sh
      - ./.env:/var/www/html/.env
      - ./ports.conf:/etc/apache2/ports.conf
```

In the containers _app_, _scheduler_, _queue_ you can override following paths:

-   **./html:/var/www/html** This is the folder containing all project files
-   **./data/app:/var/www/html/storage/app** This folder contains user data like recipe images
-   **./favicon.ico:/var/www/html/public/favicon.ico** Specify a custom favicon
-   **./entrypoint.sh:/usr/local/bin/entrypoint.sh** This script is executet at the ENTRYPOINT (see Dockerfile)
-   **./.env:/var/www/html/.env** This is the environement variable file
-   **./ports.conf:/etc/apache2/ports.conf** Specify a custom Apache HTTP port

In the container _db_ you can override following paths:

-   **./data/mysql:/var/lib/mysql** This folder contains your database

In the container _meilisearch_ you can override following paths:

-   **./data/meilisearch:/data.ms** This folder contains your indexed db models for searching

# Environement Variables

See also: [Laravel Configuration](https://laravel.com/docs/8.x/configuration)

## App specific

-   **APP_NAME:** Name of the App. _Default: RecipeManager_
-   **APP_ENV:** App environement. Possible values: "production", "local". _Default: local_
-   **APP_KEY:** Encryption key. This key will be set for you after the first startup.
-   **APP_DEBUG:** In production this value should be false. _Default: true_
-   **APP_URL:** The address, where the app should run. The port is optional. _Default: http://localhost:8000_
-   **SANCTUM_STATEFUL_DOMAINS** Your frontend domain (normally the Node.js docker container). _Default: localhost:3000_

## App versions

-   **APP_VERSION:** Docker image version.
-   **MARIADB_VERSION:** Docker image version.
-   **REDIS_VERSION:** Docker image version.
-   **MEILISEARCH_VERSION:** Docker image version.

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

# Generic settings

-   **BROADCAST_DRIVER:** _Default: log_
-   **CACHE_DRIVER:** _Default: file_
-   **QUEUE_CONNECTION:** _Default: redis_
-   **SESSION_DRIVER:** _Default: file_
-   **SESSION_LIFETIME:** _Default: 120_

# Optional features

-   **DISABLE_REGISTRATION=** Disable user registrations _Default: false_
-   **DISABLE_COOKBOOKS** Disable the cookbooks feature _Default: false_
-   **DISABLE_TAGS** Disable the tags feature _Default: false_
-   **DISABLE_RATINGS** Disable the ratings feature _Default: false_
-   **DISABLE_FOOD_CREATION** Disable the food creation by normal users feature _Default: false_
-   **DISABLE_INGREDIENT_ATTRIBUTE_CREATION** Disable the ingredient attribute creation by normal users _Default: false_
-   **PREFER_PAGINATION** Disable infinity scroll and use pagination _Default: false_
-   **MAX_RATING_STARS** Tha amount of possible rating stars _Default: 5_
