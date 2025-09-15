FROM php:8.1-apache

# Install basic system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    nano \
    && rm -rf /var/lib/apt/lists/*

# Install essential PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Create a user for Codespaces
RUN groupadd --gid 1000 vscode \
    && useradd --uid 1000 --gid vscode --shell /bin/bash --create-home vscode \
    && usermod -aG www-data vscode

# Set permissions
RUN chown -R vscode:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
