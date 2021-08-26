FROM php:8.0.9-apache
RUN apt-get update
RUN apt-get install -y libonig-dev zlib1g-dev libpng-dev libxml2-dev libzip-dev libmemcached-dev

RUN apt-get install -y default-mysql-client

RUN groupadd -g 1000 vagrant && \
    useradd -m -s /bin/bash -u 1000 -g 1000 vagrant

# extension
RUN docker-php-ext-install pdo mbstring gd xml zip pdo_mysql
RUN docker-php-source delete

# mongodb
RUN pecl install mongodb && \
    docker-php-ext-enable mongodb

# redis
RUN pecl install redis && \
    docker-php-ext-enable redis

# memcached
RUN pecl install memcached && \
   docker-php-ext-enable memcached

RUN docker-php-source delete

RUN a2enmod rewrite
COPY apache2/000-default.conf /etc/apache2/sites-available/
WORKDIR /var/hgs
