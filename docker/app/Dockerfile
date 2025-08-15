FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=nointeractive
ENV COMPOSER_HOME=/usr/bin/composer

RUN apt-get update && apt-get install -y \
    software-properties-common \
    curl \
    wget \
    lsb-release \
    ca-certificates \
    gnupg2 \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update

RUN apt-get install -y \
    php8.4-fpm \
    php8.4-cli \
    php8.4-mysql \
    php8.4-xml \
    php8.4-curl \
    php8.4-mbstring \
    php8.4-zip \
    php8.4-gd \
    php8.4-sqlite \
    php8.4-redis

RUN apt-get install -y nginx


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html

RUN sed -i 's/listen = \/run\/php\/php8.4-fpm.sock/listen = 9000/' /etc/php/8.4/fpm/pool.d/www.conf

COPY ./docker/app/nginx/conf.d/default.conf /etc/nginx/sites-available/default

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

WORKDIR /var/www/html

EXPOSE 80

CMD service php8.4-fpm start && nginx -g 'daemon off;'