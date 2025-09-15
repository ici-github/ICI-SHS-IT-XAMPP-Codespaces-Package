# 🚀 XAMPP-like Environment for GitHub Codespaces

This project provides a complete XAMPP-like development environment using GitHub Codespaces with **PHP 8.2+**, **MySQL 8.0+**, **Apache**, and **phpMyAdmin** for students at Iligan Computer Institute. All services start automatically!

## 🎓 For Students

### GitHub Codespaces Usage Limits
- **Free Accounts**: 120 hours per month
- **GitHub Student Developer Pack**: 180 hours per month (recommended)
- Usage resets monthly

### 📝 Getting GitHub Student Developer Pack
1. Register your ICI email address with GitHub
2. Visit https://education.github.com/pack to apply
3. Enable location tracking when prompted (required for verification)
4. Upload student verification documents:
   - Student ID (front and back combined into one image)
   - Certificate of Registration (COR)
5. Wait for approval email: "Welcome to GitHub Global Campus"

## 🔧 What's Included

This environment provides:
- **PHP 8.2+** with essential extensions (PDO, MySQLi, mbstring, GD, ZIP)
- **MySQL 8.0+** database server
- **Apache 2.4+** web server with SSL support
- **phpMyAdmin** for database management
- **Composer** for PHP package management
- **All services auto-start** when Codespace launches

## 🚀 Quick Start

1. **Fork this repository** to your GitHub account
2. **Open in Codespaces**:
   - Click the green `Code` button
   - Select `Codespaces` tab
   - Click `Create codespace on main`
3. **Wait for setup** (2-3 minutes) - all services start automatically
4. **Start coding!** Your environment is ready

## 🌐 Access Points

Once your Codespace is running, you can access:

| Service | URL | Purpose |
|---------|-----|---------|
| **Welcome Page** | `http://localhost/welcome.html` | Environment overview |
| **PHP Info** | `http://localhost/index.php` | PHP configuration |
| **Sample App** | `http://localhost/sample-app.php` | Demo CRUD application |
| **Database Test** | `http://localhost/test-db.php` | MySQL connection test |
| **phpMyAdmin** | `http://localhost:8080` | Database management |

## 🔐 Database Credentials

### Default MySQL Credentials
```
Host: mysql (or localhost)
Port: 3306
Root User: root
Root Password: xampp
Database: xampp
```

### Student Account (Limited Privileges)
```
Username: student
Password: student123
Databases: student_projects, xampp (limited access)
```

## 📁 File Structure

```
/var/www/html/          # Your web files go here (auto-mapped to workspace)
├── welcome.html        # Environment welcome page
├── index.php          # PHP info page
├── sample-app.php     # Demo application
├── test-db.php        # Database connection test
└── [your files]       # Add your PHP projects here
```

## 💻 Development Workflow

### Adding Your Code
1. Create PHP files directly in the workspace root
2. Files are automatically available at `http://localhost/yourfile.php`
3. Use the included sample files as templates

### Database Management
1. **phpMyAdmin**: Access at `http://localhost:8080`
2. **Command Line**: Use the integrated terminal
3. **Sample Data**: Pre-loaded with example tables

### Sample PHP Connection
```php
<?php
$host = 'mysql';  // Use 'mysql' in Codespaces, 'localhost' locally
$username = 'root';
$password = 'xampp';
$database = 'xampp';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
```

## 🛠️ Troubleshooting

### Services Not Starting
If services don't start automatically:
```bash
# Check service status
docker-compose ps

# Restart services
docker-compose restart

# View logs
docker-compose logs
```

### Database Connection Issues
1. Ensure you're using `mysql` as hostname (not `localhost`)
2. Check credentials match the ones above
3. Verify MySQL container is running: `docker-compose ps`

### File Permission Issues
```bash
# Fix permissions if needed
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html
```

## ✅ Do's and Don'ts

### ✅ Do's
- Upload your work to the workspace root directory
- Use phpMyAdmin for visual database management
- Test your code using the provided sample files
- Use the integrated VS Code terminal for commands
- Collaborate using VS Code Live Share

### ❌ Don'ts
- Don't modify `.devcontainer/` files unless necessary
- Don't store sensitive data in public repositories
- Don't share your Codespace URL publicly
- Don't manually start/stop services (they auto-start)

## 🔄 Pre-configured Features

### Auto-starting Services
All services start automatically when the Codespace launches:
- Apache web server (ports 80, 443)
- MySQL database server (port 3306)
- phpMyAdmin (port 8080)

### VS Code Extensions
Pre-installed extensions for PHP development:
- PHP Intelephense (autocompletion)
- PHP Debug (Xdebug support)
- Auto Rename Tag
- Tailwind CSS support

### Sample Data
The MySQL database includes:
- `xampp` database with sample tables
- `student_projects` database for your projects
- Sample user data for testing

## 🆘 Getting Help

1. **Check the welcome page**: `http://localhost/welcome.html`
2. **Review sample files**: Use the provided templates
3. **Check VS Code problems panel**: View any errors
4. **Use the integrated terminal**: Run diagnostic commands
5. **Contact your instructor**: For course-specific help

## 🔧 Advanced Configuration

### Adding PHP Extensions
Edit `.devcontainer/Dockerfile` to add more PHP extensions:
```dockerfile
RUN docker-php-ext-install extension_name
```

### Custom Apache Configuration
Modify `.devcontainer/apache/apache2.conf` for Apache settings.

### Custom PHP Settings
Edit `.devcontainer/php/php.ini` for PHP configuration.

---

**Ready to start coding?** Create your Codespace and begin building amazing web applications! 🎉
