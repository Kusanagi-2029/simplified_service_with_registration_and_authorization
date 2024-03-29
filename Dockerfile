# Используем базовый образ с поддержкой PHP
FROM php:8.3-fpm

# Установка необходимых зависимостей для расширений PostgreSQL и других расширений PHP
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        libpq-dev \
        libssl-dev \
        libonig-dev \
        libsodium-dev \
        libcurl4-openssl-dev \
        libxml2-dev \
        && \
    rm -rf /var/lib/apt/lists/*

# Установка расширений PHP для работы с PostgreSQL и другими
RUN docker-php-ext-install pdo_pgsql pgsql mbstring sodium

# Копируем кастомный php.ini в контейнер
COPY php.ini /usr/local/etc/php/php.ini

# Копируем исходный код вашего приложения в контейнер
COPY . /var/www/html

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Устанавливаем зависимости Composer, игнорируя требования по расширениям PHP
RUN composer install

# Установка необходимых прав доступа
RUN chown -R www-data:www-data /var/www/html
