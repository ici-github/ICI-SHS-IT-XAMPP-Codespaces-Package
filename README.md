# 🚀 XAMPP-like Environment for GitHub Codespaces

A complete **PHP 8.1+**, **MySQL 8.0+**, and **phpMyAdmin** development environment designed specifically for **GitHub Codespaces**. Perfect for students and educators who need a reliable, consistent, and accessible web development environment that works anywhere.

## ✨ Features

### 🛠️ Complete Development Stack
- **PHP 8.2** with all essential extensions
- **MySQL 8.0+** with optimized configuration
- **Apache 2.4+** with mod_rewrite and SSL support
- **phpMyAdmin** for intuitive database management
- **Composer** for PHP dependency management
- **Xdebug** for debugging support

### 🎓 Educational Features
- Pre-configured sample database with data
- Interactive CRUD demo application
- Comprehensive documentation and examples
- No local installation required - works in any browser
- Consistent environment across all student machines
- Auto-start services for immediate productivity

### 🔧 GitHub Codespaces Integration
- Automatic container startup and configuration
- Port forwarding for web access (80, 443, 3306, 8080)
- Persistent data storage
- VS Code extensions pre-installed
- Terminal access for command-line operations

## 🚀 Quick Start

### 1. Create a Codespace

1. **Fork or clone this repository** to your GitHub account
2. **Click the "Code" button** and select "Create codespace on main"
3. **Wait for the environment to initialize** (2-3 minutes)
4. **Access your application** through the forwarded ports

### 2. Access Points

Once your Codespace is running, you'll have access to:

| Service | Port | URL | Description |
|---------|------|-----|-------------|
| **Web Application** | 80 | `https://your-codespace-80.githubpreview.dev` | Your main web interface |
| **HTTPS Web App** | 443 | `https://your-codespace-443.githubpreview.dev` | Secure HTTPS access |
| **phpMyAdmin** | 8080 | `https://your-codespace-8080.githubpreview.dev` | Database management |
| **MySQL Direct** | 3306 | `your-codespace:3306` | Direct database connections |

## 📋 Database Configuration

### Connection Details

```php
// For PHP applications (internal container access)
$host = 'mysql';
$username = 'root';
$password = 'root';
$database = 'test_db';

// Alternative user account
$username = 'xampp';
$password = 'xampp';
```

### External Connections
```
Host: localhost:3306 (through port forwarding)
Username: root or xampp
Password: root or xampp
Database: test_db
```

## 📁 Project Structure

```
/
├── .devcontainer/
│   └── devcontainer.json          # Codespaces configuration
├── config/
│   ├── apache/
│   │   └── 000-default.conf       # Apache virtual host
│   ├── mysql/
│   │   └── my.cnf                 # MySQL configuration
│   ├── php/
│   │   └── php.ini                # PHP configuration
│   └── phpmyadmin-proxy.php       # phpMyAdmin access helper
├── scripts/
│   ├── setup.sh                   # Initial setup script
│   ├── start-services.sh          # Service startup script
│   └── init-db.sql               # Database initialization
├── www/                           # Your web root directory
│   ├── index.php                 # Welcome page
│   ├── sample-crud.php           # CRUD demo
│   └── [your files here]
├── docker-compose.yml             # Service orchestration
├── Dockerfile                     # Custom PHP container
└── README.md                      # This file
```

## 🎯 Getting Started with Development

### 1. Web Development
- Place your PHP files in the `/var/www/html/` directory
- Access your application through port 80 forwarding
- Use `/phpmyadmin/` for database management

### 2. Database Operations
- Access phpMyAdmin through port 8080 or `/phpmyadmin/`
- Pre-configured with sample data for learning
- Use the CRUD demo at `/sample-crud.php` as a starting point

### 3. Development Tools
- **VS Code** with PHP extensions pre-installed
- **Terminal access** for command-line operations
- **Git** pre-configured for version control
- **Composer** available for PHP packages

## 💻 Sample Code Examples

### Basic Database Connection
```php
<?php
try {
    $pdo = new PDO("mysql:host=mysql;dbname=test_db", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
```

### CRUD Operations
```php
// Create
$stmt = $pdo->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
$stmt->execute([$username, $email]);

// Read
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Update
$stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
$stmt->execute([$new_username, $id]);

// Delete
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$id]);
```

## 🛠️ Configuration Details

### PHP Configuration
- **Version**: PHP 8.2
- **Memory Limit**: 512M
- **Upload Limit**: 64M
- **Extensions**: All essential extensions included
- **Xdebug**: Configured for debugging on port 9003

### MySQL Configuration
- **Version**: MySQL 8.0+
- **Character Set**: utf8mb4
- **Storage Engine**: InnoDB
- **Authentication**: mysql_native_password

### Apache Configuration
- **Document Root**: `/var/www/html`
- **Modules**: rewrite, ssl, headers enabled
- **Virtual Hosts**: HTTP (80) and HTTPS (443)

## 🔧 Management Commands

### Service Management
```bash
# View service status
docker-compose ps

# View logs
docker-compose logs -f

# Restart services
docker-compose restart

# Stop services
docker-compose down

# Start services
docker-compose up -d
```

### Database Management
```bash
# Access MySQL CLI
docker-compose exec mysql mysql -u root -p

# Import SQL file
docker-compose exec mysql mysql -u root -p test_db < backup.sql

# Create database backup
docker-compose exec mysql mysqldump -u root -p test_db > backup.sql
```

## 🎓 Educational Use Cases

### For Students
- **Web Development Learning**: Complete LAMP stack environment
- **Database Practice**: Pre-configured MySQL with sample data
- **Project Development**: Ready-to-use environment for assignments
- **Collaboration**: Share Codespace links for pair programming

### For Educators
- **Consistent Environment**: All students use identical setup
- **No Installation Issues**: Works in any web browser
- **Easy Distribution**: Share repository link
- **Quick Assessment**: Access student work through Codespaces

## 🐛 Troubleshooting

### Common Issues

**Services not starting?**
```bash
# Check container status
docker-compose ps

# View detailed logs
docker-compose logs

# Restart everything
docker-compose restart
```

**Can't access phpMyAdmin?**
- Wait 2-3 minutes for full startup
- Check port 8080 forwarding in Codespaces
- Visit `/phpmyadmin/` for the proxy interface

**Database connection issues?**
- Ensure MySQL container is running: `docker-compose ps`
- Check credentials: root/root or xampp/xampp
- Wait for MySQL to fully initialize (may take 1-2 minutes)

**File permission issues?**
```bash
# Fix permissions
sudo chown -R vscode:www-data /var/www/html
sudo chmod -R 755 /var/www/html
```

## 📊 System Requirements

- **GitHub Account** with Codespaces access
- **Web Browser** (Chrome, Firefox, Safari, Edge)
- **Internet Connection** for initial setup

## 🔒 Security Notes

- This environment is designed for **development and education**
- Default passwords are used for simplicity
- **Not suitable for production** without security hardening
- Always use strong passwords in production environments

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 🆘 Support

- **Issues**: [GitHub Issues](https://github.com/your-username/repository/issues)
- **Discussions**: [GitHub Discussions](https://github.com/your-username/repository/discussions)
- **Documentation**: This README and inline comments

## 🌟 Acknowledgments

- Built for educational purposes
- Inspired by XAMPP's simplicity
- Optimized for GitHub Codespaces environment
- Designed with students and educators in mind

---

**Happy coding! 🎉**

*This XAMPP-like environment brings the power of professional web development to any browser, making it perfect for learning, teaching, and rapid prototyping.*
