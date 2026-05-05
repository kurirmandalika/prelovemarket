FROM php:8.2-cli

# install system deps
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# copy project
COPY . .

# install dependency
RUN composer install --no-dev --optimize-autoloader

# install node + build assets
RUN apt-get install -y nodejs npm
RUN npm install && npm run build

# expose port
EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000