FROM php:8.2-fpm


# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install apt-utils
RUN apt-get update && apt-get install apt-utils

# Install system dependencies
RUN apt-get install -y \
    git \
    zip  \
    curl  \
    unzip  \
    g++   \
    gcc    \
    openssl \
    libzip-dev\
    libssh-dev \
    libjpeg-dev \
    libssl-dev\
    libbz2-dev \
    libxml2-dev \
    libpng-dev \
    libonig-dev \
    libmcrypt-dev \
    librabbitmq-dev\
    libreadline-dev \
    libfreetype6-dev \
    curl        \
    libicu-dev   \
    libpcre3-dev  \
    build-essential\
    libcurl4-openssl-dev


# Point to Public Dir for Laravel App
#ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
#RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
#RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf    


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions **(Redis, Mongo, Amqp will only work for PHP 8 within this block)
RUN docker-php-ext-install \
    gd \
    bz2 \
    intl \
    zip\ 
    exif \
    iconv \
    pcntl  \
    opcache \
    calendar \
    xml   \
    bcmath \
    mbstring\
    pdo_mysql \  
    sockets

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Pull NodeJs From REPO
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash

RUN apt-get install -y nodejs
RUN apt-get install -y yarn
RUN #apt-get install

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Copy Everything from local to docker-volume
COPY ./ /var/www/html

# Set working directory
WORKDIR /var/www/html

# Set User
USER $user

# Expose Port for Forwarding
EXPOSE 80