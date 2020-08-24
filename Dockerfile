FROM php:7.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl gnupg ca-certificates \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && curl -L https://deb.nodesource.com/setup_12.x | bash \
    && apt-get update -yq \
    && apt-get install -yq \
        dh-autoreconf=19 \
        ruby=1:2.5.* \
        ruby-dev=1:2.5.* \
        nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
    bcmath \
    pdo_mysql \
    intl \
    pcntl \
    opcache \
    exif \
    gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# set our application folder as an environment variable
ENV APP_HOME /var/www/html

# change uid and gid of apache to docker user uid/gid
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# change the web_root to laravel /var/www/html/public folder
RUN sed -i -e "s/html/html\/public/g" /etc/apache2/sites-enabled/000-default.conf

# enable apache module rewrite
RUN a2enmod rewrite

# copy source files and run composer
COPY . $APP_HOME

# Get init data
COPY docker/root /
RUN chmod a+x /usr/local/bin/init-recipe-manager.sh

# Install dependencies
RUN composer install --optimize-autoloader --no-dev
RUN npm install

# change ownership of our applications
RUN chown -R www-data:www-data $APP_HOME

ENTRYPOINT /usr/local/bin/init-recipe-manager.sh
