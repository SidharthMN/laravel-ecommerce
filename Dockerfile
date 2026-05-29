# Use PHP 8.2 with FPM
FROM php:8.2-fpm

# Set working directory
WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    xml

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer files
COPY composer.json ./

# Copy application files
COPY . .

# Install PHP dependencies
RUN mkdir -p bootstrap/cache
RUN chmod -R 775 bootstrap/cache
RUN composer install --no-interaction --no-dev --optimize-autoloader


# Copy .env.example to .env if .env doesn't exist
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Set permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Expose port (FPM uses 9000 internally)
EXPOSE 9000

# Run PHP-FPM
CMD ["php-fpm"]
