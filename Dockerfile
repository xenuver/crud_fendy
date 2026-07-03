FROM php:8.2-apache

# Install required packages and PHP extensions for CodeIgniter 4 & PhpSpreadsheet
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install intl pdo pdo_mysql mysqli zip gd mbstring \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Update Apache DocumentRoot to point to CodeIgniter's public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Ensure writable directory exists with standard CI4 subdirectories
RUN mkdir -p /var/www/html/writable/cache \
    /var/www/html/writable/logs \
    /var/www/html/writable/session \
    /var/www/html/writable/uploads

# Set permissions for the writable folder so web server can write to it
RUN chown -R www-data:www-data /var/www/html/writable
RUN chmod -R 775 /var/www/html/writable

# Create storage link (symlink) from writable/uploads to public/uploads
# This makes uploaded files accessible from the web
RUN ln -s /var/www/html/writable/uploads /var/www/html/public/uploads

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install dependencies via composer
RUN composer install --no-dev --optimize-autoloader

EXPOSE 80
