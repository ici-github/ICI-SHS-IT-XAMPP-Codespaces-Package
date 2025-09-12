FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    wget \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libicu-dev \
    mariadb-client \
    vim \
    nano \
    htop \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mysqli \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        xml \
        soap

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache modules
RUN a2enmod rewrite ssl headers expires deflate

# Install Node.js and npm (for modern web development)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Create setup script
RUN cat > /usr/local/bin/setup-xampp.sh << 'EOF'
#!/bin/bash
set -e

echo "Starting XAMPP-like environment setup..."

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
timeout=60
while ! mysqladmin ping -h mysql -u root -pxampp --silent 2>/dev/null; do
    sleep 2
    timeout=$((timeout - 2))
    if [ $timeout -le 0 ]; then
        echo "MySQL connection timeout. Continuing anyway..."
        break
    fi
done

if mysqladmin ping -h mysql -u root -pxampp --silent 2>/dev/null; then
    echo "MySQL is ready!"
else
    echo "MySQL not accessible, but continuing setup..."
fi

# Create a sample index.php file if it doesn't exist
if [ ! -f /var/www/html/index.php ]; then
    cat > /var/www/html/index.php << 'PHPEOF'
<?php
// PHP Information Page
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Information - XAMPP-like Environment</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f7fa; }
        .nav { text-align: center; margin-bottom: 20px; padding: 15px; background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .nav a { color: #667eea; text-decoration: none; margin: 0 15px; font-weight: 500; }
        .nav a:hover { text-decoration: underline; }
        .info-container { background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); overflow: hidden; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="welcome.html">← Back to Welcome</a> |
        <a href="sample-app.php">Sample App</a> |
        <a href="test-db.php">Database Test</a> |
        <a href="http://localhost:8080" target="_blank">phpMyAdmin</a>
    </div>
    <div class="info-container">';
phpinfo();
echo '</div></body></html>';
?>
PHPEOF
fi

# Create a sample database connection test file
if [ ! -f /var/www/html/test-db.php ]; then
    cat > /var/www/html/test-db.php << 'PHPEOF'
<?php
$host = 'mysql';
$username = 'root';
$password = 'xampp';
$database = 'xampp';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<h2>Database Connection Successful!</h2>";
    echo "<p>Connected to MySQL database: $database</p>";
    
    // Show current databases
    $stmt = $pdo->query('SHOW DATABASES');
    echo "<h3>Available Databases:</h3><ul>";
    while ($row = $stmt->fetch()) {
        echo "<li>" . $row[0] . "</li>";
    }
    echo "</ul>";
    
} catch(PDOException $e) {
    echo "<h2>Connection failed:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>
PHPEOF
fi

# Set proper permissions
chown -R www-data:www-data /var/www/html 2>/dev/null || true
chmod -R 755 /var/www/html 2>/dev/null || true

echo "XAMPP-like environment setup completed!"
echo "Services available:"
echo "- Apache: http://localhost:80"
echo "- phpMyAdmin: http://localhost:8080"
echo "- MySQL: localhost:3306"

# Start Apache in foreground (this is the main process)
exec apache2-foreground
EOF

RUN chmod +x /usr/local/bin/setup-xampp.sh

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Expose ports
EXPOSE 80 443

# Start setup script
CMD ["/usr/local/bin/setup-xampp.sh"]