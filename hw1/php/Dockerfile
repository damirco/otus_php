FROM php:8.5-fpm

# Устанавливаем системные зависимости
RUN apt-get update && apt-get install -y \
    libmemcached-dev \
    zlib1g-dev \
    libssl-dev \
    libpq-dev \
    unzip \
    curl \
    git \
    && rm -rf /var/lib/apt/lists/*

# Устанавливаем встроенные расширения PHP для PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# Устанавливаем расширения через PECL (Redis и Memcached)
RUN pecl install redis memcached && docker-php-ext-enable redis memcached

# Устанавливаем Composer из образа, т.к. при установке через curl часто бывают ошибки
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Переопределяем стандартный порт на Unix-сокет
COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /var/www/html
