    FROM php:8.0-fpm
     
    RUN docker-php-ext-install mysqli

    RUN apt-get -y update \
    && apt-get install -y libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl