FROM php:8.5-fpm

RUN apt-get update && apt-get install -y libzip-dev

COPY www.conf /usr/local/etc/php-fpm.d/www.conf
COPY app /var/www/html

CMD ["php-fpm"]
