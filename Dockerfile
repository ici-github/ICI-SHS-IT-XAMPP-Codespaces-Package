FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libgd-dev \
    libicu-dev \
    libxslt-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    zip \
    unzip \
    nano \
    vim \
    wget \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mysqli \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        xsl \
        soap \
        curl \
        json \
        xml \
        dom \
        xmlwriter \
        simplexml \
        fileinfo \
        tokenizer \
        ctype \
        iconv \
        session \
        filter

# Install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache modules
RUN a2enmod rewrite ssl headers

# Configure Apache for phpMyAdmin
RUN echo "Alias /phpmyadmin /var/www/phpmyadmin" >> /etc/apache2/sites-available/000-default.conf \
    && echo "<Directory /var/www/phpmyadmin>" >> /etc/apache2/sites-available/000-default.conf \
    && echo "    AllowOverride All" >> /etc/apache2/sites-available/000-default.conf \
    && echo "    Require all granted" >> /etc/apache2/sites-available/000-default.conf \
    && echo "</Directory>" >> /etc/apache2/sites-available/000-default.conf

# Create phpMyAdmin proxy
RUN mkdir -p /var/www/html/phpmyadmin
COPY config/phpmyadmin-proxy.php /var/www/html/phpmyadmin/index.php

# Set working directory
WORKDIR /var/www/html

# Create a non-root user
RUN groupadd --gid 1000 vscode \
    && useradd --uid 1000 --gid vscode --shell /bin/bash --create-home vscode \
    && usermod -aG www-data vscode

# Give proper permissions
RUN chown -R vscode:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose ports
EXPOSE 80 443

# Start Apache
CMD ["apache2-foreground"]
