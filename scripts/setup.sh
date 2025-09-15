#!/bin/bash

echo "🚀 Setting up Basic PHP & MySQL environment..."

# Create necessary directories
mkdir -p /var/www/html/logs

# Set proper permissions
sudo chown -R vscode:www-data /var/www/html
sudo chmod -R 755 /var/www/html

echo "✅ Basic setup completed!"
echo "🌐 Your PHP & MySQL environment is ready!"
