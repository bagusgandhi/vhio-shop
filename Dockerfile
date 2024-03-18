FROM php:8.1.30-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip

RUN apt-get update -y \
    && apt-get install nginx -y

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Source Codes
COPY --chown=www-data:www-data . /var/www/html

WORKDIR /var/www/html

ENV APP_ENV production

# Install Dependencies & Optimize
RUN composer install --no-interaction --no-dev --optimize-autoloader --no-cache
RUN php artisan optimize

COPY docker/nginx-site.conf /etc/nginx/sites-enabled/default
COPY docker/entrypoint.sh /etc/entrypoint.sh

RUN chmod +x /etc/entrypoint.sh

EXPOSE 80 443

CMD ["/etc/entrypoint.sh"]
