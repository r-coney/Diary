FROM php:8.2.3-fpm

RUN curl -fsSL https://deb.nodesource.com/setup_19.x | bash - && \
    apt-get update && apt-get install -y \
    nodejs \
    cron \
    gnupg \
    libzip-dev \
    libpng-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    locales \
    unzip \
    vim \
    zip \
    zlib1g-dev \
    zlib1g-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install \
    pdo_mysql \
    opcache

RUN npm update && \
    npm add -D sass && \
    npm install jquery --save && \
    npm install @popperjs/core --save

COPY --from=composer:2.2.5 /usr/bin/composer /usr/bin/composer

COPY ./php.ini /usr/local/etc/php/php.ini
