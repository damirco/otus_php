FROM php:8.5-fpm

RUN apt-get update && apt-get install -y libzip-dev \
    && pecl install redis && docker-php-ext-enable redis

COPY www.conf /usr/local/etc/php-fpm.d/www.conf
COPY app /var/www/html

CMD ["php-fpm"]
