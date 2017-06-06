FROM php:7.1-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    apt-utils \
    zip \
    unzip \
    ssh \
    g++ \
    git \
    curl \
    libcurl4-gnutls-dev \
    libpq-dev \
    libicu-dev \
&& \
    docker-php-ext-install \
    intl \
    curl \
    bcmath \
    gettext \
    mbstring \
    pdo_pgsql \
&& \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
&& \
   composer install --prefer-source --no-interaction && \
   chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

COPY . ./

EXPOSE 80
