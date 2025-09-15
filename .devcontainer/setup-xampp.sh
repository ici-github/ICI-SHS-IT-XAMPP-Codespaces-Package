#!/bin/bash
set -e

echo "Starting XAMPP-like environment setup..."

# Wait for MySQL to be ready (with timeout)
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

# Set proper permissions
chown -R www-data:www-data /var/www/html 2>/dev/null || true
chmod -R 755 /var/www/html 2>/dev/null || true

echo "XAMPP-like environment setup completed!"
echo "Services available:"
echo "- Apache: http://localhost:80"
echo "- phpMyAdmin: http://localhost:8080"
echo "- MySQL: localhost:3306"

# Start Apache in foreground
exec apache2-foreground
