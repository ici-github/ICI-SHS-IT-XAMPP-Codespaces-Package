# Use official PHP 8.2 with Apache
FROM php:8.2-apache

# Set environment variables to avoid interactive prompts
ENV DEBIAN_FRONTEND=noninteractive

# Install system dependencies and MariaDB
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    wget \
    sudo \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    mariadb-server \
    mariadb-client \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mysqli \
        mbstring \
        gd \
        zip

# Install phpMyAdmin
RUN wget https://www.phpmyadmin.net/downloads/phpMyAdmin-latest-all-languages.zip -O /tmp/phpmyadmin.zip \
    && unzip /tmp/phpmyadmin.zip -d /usr/share \
    && mv /usr/share/phpMyAdmin-*-all-languages /usr/share/phpmyadmin \
    && rm /tmp/phpmyadmin.zip

# Enable Apache modules
RUN a2enmod rewrite ssl headers

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the ServerName directive globally to suppress the warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expose port 80
EXPOSE 80

# Keep the container running by starting the startup script
CMD ["/bin/bash", "-c", "/workspaces/${localWorkspaceFolderBasename}/startup.sh"]