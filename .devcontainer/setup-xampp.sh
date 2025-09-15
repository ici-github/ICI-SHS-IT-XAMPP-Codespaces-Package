#!/bin/bash
set -e

echo "Starting XAMPP-like environment setup..."

# Set the document root dynamically - use the workspace folder
DOC_ROOT="/workspaces/${CODESPACE_NAME}/htdocs"

# Fallback if CODESPACE_NAME is not set
if [ -z "$CODESPACE_NAME" ]; then
    DOC_ROOT="/workspaces/$(ls /workspaces/ | head -1)/htdocs"
fi

echo "Document root: $DOC_ROOT"

# Create the htdocs directory and set permissions
mkdir -p "$DOC_ROOT" && chown -R www-data:www-data "$DOC_ROOT" && chmod -R 755 "$DOC_ROOT"

# Copy sample files if htdocs is empty
if [ ! -f "$DOC_ROOT/index.html" ]; then
    echo "Copying sample files to htdocs..."
    # Find the workspace directory and copy htdocs content
    WORKSPACE_DIR="/workspaces/$(ls /workspaces/ | head -1)"
    if [ -d "$WORKSPACE_DIR/htdocs" ]; then
        cp -r "$WORKSPACE_DIR/htdocs/"* "$DOC_ROOT/" 2>/dev/null || echo "No files to copy"
    fi
    
    # Create a basic index file if none exists
    if [ ! -f "$DOC_ROOT/index.html" ]; then
        cat > "$DOC_ROOT/index.html" << 'EOF'
<!DOCTYPE html>
<html><head><title>XAMPP Environment</title></head>
<body><h1>Welcome to XAMPP-like Environment</h1>
<p>PHP and MariaDB are running!</p>
<p><a href="/phpmyadmin">Access phpMyAdmin</a></p>
</body></html>
EOF
    fi
    chown -R www-data:www-data "$DOC_ROOT"
fi

# Configure Apache to use the dynamic document root and enable directory indexing
sed -i "s|/var/www/html|$DOC_ROOT|g" /etc/apache2/sites-available/000-default.conf
echo "<Directory $DOC_ROOT>
    Options Indexes FollowSymLinks
    AllowOverride None
    Require all granted
</Directory>" >> /etc/apache2/apache2.conf

# Configure Apache to serve phpMyAdmin from /phpmyadmin
echo "Alias /phpmyadmin /usr/share/phpmyadmin" > /etc/apache2/conf-available/phpmyadmin.conf
a2enconf phpmyadmin

echo "Configuring phpMyAdmin..."

# Initialize and start MariaDB
echo "Starting MariaDB..."
service mysql start

# Wait for MariaDB to be ready
echo "Waiting for MariaDB to start..."
sleep 10

# Configure MariaDB with specified username, password, and database name
echo "Configuring MariaDB..."
mysql -e "CREATE DATABASE IF NOT EXISTS mariadb;" 2>/dev/null || echo "Database already exists"
mysql -e "CREATE USER IF NOT EXISTS 'mariadb'@'localhost' IDENTIFIED BY 'mariadb';" 2>/dev/null || echo "User already exists"
mysql -e "GRANT ALL PRIVILEGES ON mariadb.* TO 'mariadb'@'localhost';" 2>/dev/null || true
mysql -e "FLUSH PRIVILEGES;" 2>/dev/null || true

echo "XAMPP-like environment setup completed!"
echo "Services available:"
echo "- Apache: http://localhost"
echo "- phpMyAdmin: http://localhost/phpmyadmin"
echo "- MariaDB: localhost:3306 (user: mariadb, pass: mariadb)"
echo "- Document root: $DOC_ROOT"

echo "Starting Apache in foreground..."

# Start Apache in foreground to keep container running
exec apache2-foreground
