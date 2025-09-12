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
COPY <<EOF /usr/local/bin/setup-xampp.sh
#!/bin/bash

# Start Apache in background
apache2ctl start

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
while ! mysqladmin ping -h mysql -u root -pxampp --silent; do
    sleep 1
done

echo "MySQL is ready!"

# Create a sample index.php file if it doesn't exist
if [ ! -f /var/www/html/index.php ]; then
    cat > /var/www/html/index.php << 'PHPEOF'
<?php
phpinfo();
?>
PHPEOF
fi

# Create a sample database connection test file
if [ ! -f /var/www/html/test-db.php ]; then
    cat > /var/www/html/test-db.php << 'PHPEOF'
<?php
\$host = 'mysql';
\$username = 'root';
\$password = 'xampp';
\$database = 'xampp';

try {
    \$pdo = new PDO("mysql:host=\$host;dbname=\$database", \$username, \$password);
    \$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<h2>Database Connection Successful!</h2>";
    echo "<p>Connected to MySQL database: \$database</p>";
    
    // Show current databases
    \$stmt = \$pdo->query('SHOW DATABASES');
    echo "<h3>Available Databases:</h3><ul>";
    while (\$row = \$stmt->fetch()) {
        echo "<li>" . \$row[0] . "</li>";
    }
    echo "</ul>";
    
} catch(PDOException \$e) {
    echo "<h2>Connection failed:</h2>";
    echo "<p>" . \$e->getMessage() . "</p>";
}
?>
PHPEOF
fi

# Create a welcome page
if [ ! -f /var/www/html/welcome.html ]; then
    cat > /var/www/html/welcome.html << 'HTMLEOF'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XAMPP-like Environment - GitHub Codespaces</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 3px solid #007acc; padding-bottom: 10px; }
        .service { margin: 20px 0; padding: 15px; background: #f9f9f9; border-left: 4px solid #007acc; }
        .status { color: #28a745; font-weight: bold; }
        a { color: #007acc; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 XAMPP-like Environment for GitHub Codespaces</h1>
        
        <div class="service">
            <h3>📊 PHP Information</h3>
            <p><span class="status">✅ Active</span> - <a href="index.php" target="_blank">View PHP Info</a></p>
        </div>
        
        <div class="service">
            <h3>🗄️ Database Connection Test</h3>
            <p><span class="status">✅ Active</span> - <a href="test-db.php" target="_blank">Test MySQL Connection</a></p>
        </div>
        
        <div class="service">
            <h3>🔧 phpMyAdmin</h3>
            <p><span class="status">✅ Active</span> - <a href="http://localhost:8080" target="_blank">Access phpMyAdmin</a></p>
            <p><strong>Login:</strong> root / xampp</p>
        </div>
        
        <div class="service">
            <h3>📚 Development Info</h3>
            <ul>
                <li><strong>PHP Version:</strong> 8.2+</li>
                <li><strong>MySQL Version:</strong> 8.0+</li>
                <li><strong>Apache Ports:</strong> 80 (HTTP), 443 (HTTPS)</li>
                <li><strong>MySQL Port:</strong> 3306</li>
                <li><strong>phpMyAdmin Port:</strong> 8080</li>
            </ul>
        </div>
        
        <div class="service">
            <h3>🎓 For Students</h3>
            <p>This environment provides a complete XAMPP-like setup that works anywhere with GitHub Codespaces!</p>
            <ul>
                <li>All services start automatically</li>
                <li>Full PHP development environment</li>
                <li>MySQL database with phpMyAdmin</li>
                <li>Apache web server with SSL support</li>
            </ul>
        </div>
    </div>
</body>
</html>
HTMLEOF
fi

echo "XAMPP-like environment setup completed!"
echo "Services running:"
echo "- Apache: http://localhost:80"
echo "- phpMyAdmin: http://localhost:8080"
echo "- MySQL: localhost:3306"

# Keep Apache running in foreground
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