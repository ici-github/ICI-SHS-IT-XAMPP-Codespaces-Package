#!/bin/bash

echo "🔄 Starting XAMPP-like services..."

# Function to wait for a service to be ready
wait_for_service() {
    local service_name=$1
    local port=$2
    local max_attempts=30
    local attempt=1
    
    echo "⏳ Waiting for $service_name to be ready..."
    
    while [ $attempt -le $max_attempts ]; do
        if nc -z localhost $port 2>/dev/null; then
            echo "✅ $service_name is ready!"
            return 0
        fi
        
        echo "   Attempt $attempt/$max_attempts - $service_name not ready yet..."
        sleep 2
        ((attempt++))
    done
    
    echo "❌ $service_name failed to start within expected time"
    return 1
}

# Start Docker Compose services in the background
echo "🐳 Starting Docker Compose services..."
cd /var/www/html
docker-compose up -d

# Wait for services to be ready
wait_for_service "MySQL" 3306
wait_for_service "Apache" 80
wait_for_service "phpMyAdmin" 8080

# Show service status
echo ""
echo "📊 Service Status:"
echo "==================="

# Check MySQL
if nc -z localhost 3306 2>/dev/null; then
    echo "✅ MySQL: Running on port 3306"
else
    echo "❌ MySQL: Not responding"
fi

# Check Apache
if nc -z localhost 80 2>/dev/null; then
    echo "✅ Apache: Running on port 80"
else
    echo "❌ Apache: Not responding"
fi

# Check if SSL is available
if nc -z localhost 443 2>/dev/null; then
    echo "✅ Apache SSL: Running on port 443"
else
    echo "⚠️  Apache SSL: Not available (this is normal in Codespaces)"
fi

# Check phpMyAdmin
if nc -z localhost 8080 2>/dev/null; then
    echo "✅ phpMyAdmin: Running on port 8080"
else
    echo "❌ phpMyAdmin: Not responding"
fi

echo ""
echo "🎉 XAMPP-like environment is ready!"
echo "🌐 Access your application at the forwarded port"
echo "🗃️  Access phpMyAdmin at /phpmyadmin"
echo ""
echo "📝 To view logs:"
echo "   docker-compose logs -f"
echo ""
echo "🔧 To restart services:"
echo "   docker-compose restart"
echo ""
