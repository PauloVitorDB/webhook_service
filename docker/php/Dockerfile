FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        --no-install-recommends \
        curl \
        apt-transport-https \
        apt-utils \
        zlib1g-dev \
        libxml2-dev \
        libpng-dev \
        libonig-dev \
        zip \
        unzip \
        nano 

# php.ini
COPY php.ini "$PHP_INI_DIR/php.ini"

# User
ARG user=adsomos
ARG uid=1000

RUN mkdir /home/$user
RUN useradd -u $uid -d /home/$user $user
RUN usermod -a -G www-data,root $user
RUN chown -R $user:www-data /home/$user

USER $user

# Composer
RUN mkdir -p /home/$user/.composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer 

WORKDIR /var/www

EXPOSE 9003

CMD ["php-fpm"]