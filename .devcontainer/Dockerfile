FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies (essential only)
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    mariadb-client \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions (basic and essential only)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mysqli \
        mbstring \
        gd \
        zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache modules
RUN a2enmod rewrite ssl headers expires

# Copy setup script
COPY setup-xampp.sh /usr/local/bin/setup-xampp.sh
RUN chmod +x /usr/local/bin/setup-xampp.sh

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Expose ports
EXPOSE 80 443

# Start setup script
CMD ["/usr/local/bin/setup-xampp.sh"]