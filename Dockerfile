FROM php:8.0-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid



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

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*


# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u 1000 -d /home/foulen foulen
RUN mkdir -p /home/foulen/.composer && \
    chown -R foulen:foulen /home/foulen

# Set working directory
WORKDIR /var/www

COPY --chown=foulen:foulen . .

RUN composer install

USER foulen

EXPOSE 9000
