#!/bin/bash

# Set the document root dynamically
DOC_ROOT="/workspaces/$(basename $(pwd))/htdocs"

# Create the htdocs directory and set permissions
mkdir -p $DOC_ROOT && chown -R www-data:www-data $DOC_ROOT && chmod -R 755 $DOC_ROOT

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

# Start Apache in background
service apache2 start

# Initialize and start MariaDB
service mysql start

# Wait for MariaDB to be ready
echo "Waiting for MariaDB to start..."
sleep 5

# Configure MariaDB with specified username, password, and database name
mysql -e "CREATE DATABASE IF NOT EXISTS mariadb;"
mysql -e "CREATE USER IF NOT EXISTS 'mariadb'@'localhost' IDENTIFIED BY 'mariadb';"
mysql -e "GRANT ALL PRIVILEGES ON mariadb.* TO 'mariadb'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

echo "XAMPP-like environment setup completed!"
echo "Services available:"
echo "- Apache: http://localhost"
echo "- phpMyAdmin: http://localhost/phpmyadmin"
echo "- MariaDB: localhost:3306 (user: mariadb, pass: mariadb)"
echo "- Document root: $DOC_ROOT"

# Start Apache in foreground to keep container running
exec apache2-foreground
