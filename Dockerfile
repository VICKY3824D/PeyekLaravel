FROM php:8.3-fpm

# 1. Install dependencies
RUN apt-get update \
    && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libzip-dev zip unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www

# 2. Copy Composer binary (Fixed syntax)
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# 3. Copy project files
COPY . .

# 4. LOGIC PENTING: Jika ada .env.prod, jadikan itu sebagai .env utama
# Ini memastikan Laravel membaca config production
RUN if [ -f .env.prod ]; then cp .env.prod .env; fi

# 5. Install dependencies
RUN composer install --no-dev --optimize-autoloader

# 6. Set permissions (Fixed syntax error here)
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
