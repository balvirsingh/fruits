# Dockerfile
FROM php:8.2-apache AS base

# ENABLE REWRITING
RUN a2enmod rewrite

# OS PACKAGES
#RUN apt-get update && apt-get install -y wget libzip-dev git gnupg unixodbc-dev
RUN apt-get update && apt-get install -y \
    wget \
    libzip-dev \
    apt-utils\
    unzip \
    git \
    libicu-dev \
    xvfb \
    libfontconfig \
    wkhtmltopdf \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zlib1g-dev \
    && docker-php-ext-install zip pdo pdo_mysql opcache \
    #&& docker-php-ext-install gd \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install calendar

# DOCROOT SETUP
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN rm /etc/apache2/sites-enabled/000-default.conf
COPY docker/vhost.conf /etc/apache2/sites-enabled/
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# PHP INI 
COPY docker/php.ini $PHP_INI_DIR

# COPY COMPOSER 2.<LATEST> AND INSTALL
RUN wget https://getcomposer.org/composer-2.phar
RUN mv composer-2.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer

# SET USER PERMISSIONS FOR COPIED APP.
RUN chown -R www-data:www-data /var/www/html

# SET USER PERMISSIONS FOR MOUNTED VOLUMES.
RUN usermod -u 1000 www-data