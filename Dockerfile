FROM php:8.0-apache

# set the application folder as env variable
ENV APP_HOME /var/www/html

# Install system dependencies
RUN curl -L https://deb.nodesource.com/setup_15.x | bash
RUN apt-get update
RUN apt-get install -y \
    jpegoptim optipng pngquant gifsicle \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libonig-dev \
    libxml2-dev \
    nodejs \
    git \
    sudo

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN pecl install redis
RUN rm -rf /tmp/pear
RUN docker-php-ext-enable redis

RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp

RUN docker-php-ext-install -j$(nproc) \
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

# change the web root to /var/www/html/public and port to 8080
RUN sed -i -e "s/html/html\/public/g" /etc/apache2/sites-enabled/000-default.conf
RUN sed -i -e "s/80/8080/g" /etc/apache2/sites-enabled/000-default.conf

# enable apache module rewrite
RUN a2enmod rewrite

# copy source files and run composer
COPY . $APP_HOME

# Get init data
COPY storage/docker/root /
RUN chmod a+x /usr/local/bin/entrypoint.sh
RUN chown www-data:www-data /etc/apache2/ports.conf

# Install dependencies
RUN composer install --optimize-autoloader --no-dev
RUN npm install

# change ownership of our applications
RUN chown -R www-data:www-data $APP_HOME

ENTRYPOINT /usr/local/bin/entrypoint.sh
