FROM ubuntu

RUN apt-get update

RUN apt-get install -y software-properties-common 
RUN add-apt-repository ppa:ondrej/php

RUN apt-get update \
    && apt-get install -y curl zip unzip  \
       php8.0 php-cli php-curl \
        php-mbstring php-xml php-pgsql postgresql-client

RUN  curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get update


RUN  curl -s https://getcomposer.org/installer | php
RUN  mv composer.phar /usr/local/bin/composer

WORKDIR /app
COPY . .


RUN composer install


CMD php artisan serve --host=0.0.0.0 --port=8181
EXPOSE 8181