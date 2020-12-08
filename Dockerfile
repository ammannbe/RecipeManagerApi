FROM php:7.4-apache

# set the application folder as env variable
ENV APP_HOME /var/www/html

# Install system dependencies
RUN curl -L https://deb.nodesource.com/setup_15.x | bash
RUN apt-get update
RUN apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    nodejs \
    git

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

# change uid/gid of apache to docker user
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# change the web_root to /var/www/html/public
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
