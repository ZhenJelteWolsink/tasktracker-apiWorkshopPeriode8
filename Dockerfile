FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
git \
unzip \
libzip-dev \
libsqlite3-dev \
&& docker-php-ext-install pdo pdo_sqlite zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install

RUN chmod +x entrypoint.sh

EXPOSE 8000

CMD ["sh", "entrypoint.sh"]