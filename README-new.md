# ICI IT Codespace PHP/MariaDB/phpMyAdmin

This project sets up a development environment using GitHub Codespaces with PHP 8.2, MariaDB, and phpMyAdmin for students in Iligan Computer Institute. This is an improved single-container setup based on the proven ICI template architecture.

## 🚀 Quick Start

1. **Create a Codespace**: Click the "Code" button → "Codespaces" → "Create codespace on main"
2. **Wait for setup**: The environment will automatically configure (2-3 minutes)
3. **Start developing**: Upload your PHP files to the `htdocs/` directory
4. **Access services**: Use the forwarded ports to access your applications

## 📋 Services & Access

### 🌐 Apache Web Server
- **URL**: `http://localhost`
- **Document Root**: `/workspaces/[repo-name]/htdocs/`
- **PHP Version**: 8.2 with essential extensions

### 🗄️ MariaDB Database
- **Host**: `localhost`
- **Port**: `3306` (internal)
- **Username**: `mariadb`
- **Password**: `mariadb`
- **Database**: `mariadb`

### ⚙️ phpMyAdmin
- **URL**: `http://localhost/phpmyadmin`
- **Access**: Use the MariaDB credentials above
- **Features**: Complete database management interface

## 🛠️ Development Workflow

### 1. Upload Your Files
```bash
# All your PHP files go in the htdocs directory
htdocs/
├── index.html          # Default welcome page
├── test-db.php         # Database connection test
├── info.php            # PHP information
└── your-project/       # Your PHP application
```

### 2. Database Management
- Open phpMyAdmin at `/phpmyadmin`
- Login with username: `mariadb`, password: `mariadb`
- Create databases, tables, and manage data visually

### 3. Testing Your Code
- Visit `http://localhost` to see your applications
- Use `test-db.php` to verify database connectivity
- Check `info.php` for PHP configuration details

## 📝 Sample PHP Database Connection

```php
<?php
$servername = "localhost";
$username = "mariadb";
$password = "mariadb";
$dbname = "mariadb";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully!";
mysqli_close($conn);
?>
```

## ⚡ Features

- **PHP 8.2** with essential extensions (PDO, MySQLi, GD, mbstring, ZIP)
- **MariaDB** database server with automatic setup
- **phpMyAdmin** for visual database management
- **Apache** web server with mod_rewrite enabled
- **Automatic startup** - everything starts when Codespace loads
- **Pre-configured** - no manual setup required

## 🎯 Best Practices

### ✅ Do's
- Upload your work to the `htdocs` directory
- Use phpMyAdmin for database management
- Test your database connections regularly
- Follow PHP best practices and security guidelines

### ❌ Don'ts
- Don't modify configuration files unless necessary
- Don't store sensitive data in your repository
- Don't share your Codespace URL publicly
- Don't delete the `htdocs` directory

## 🔧 Troubleshooting

### Services Not Starting
1. **Check Codespace status**: Wait for full initialization (2-3 minutes)
2. **Restart if needed**: Delete and recreate the Codespace
3. **Manual restart**: Open terminal and run `sudo service mysql restart`

### Database Connection Issues
1. **Verify credentials**: Use `mariadb`/`mariadb` for username/password
2. **Test connection**: Run the `test-db.php` file
3. **Check phpMyAdmin**: Access `/phpmyadmin` to verify database is running

### File Access Issues
1. **Check permissions**: Files should be in `htdocs/` directory
2. **Refresh browser**: Clear cache if changes don't appear
3. **Check file paths**: Ensure URLs match file locations

## 🏫 For ICI Students

This environment is specifically designed for Iligan Computer Institute students. To get the most out of GitHub Codespaces:

1. **Use your ICI email** for GitHub account registration
2. **Apply for GitHub Student Pack** for extended Codespace hours
3. **Follow course guidelines** for project submissions
4. **Ask for help** if you encounter issues

## 📚 Technical Details

- **Base Image**: Ubuntu 20.04
- **PHP**: 8.2 with Apache integration
- **Database**: MariaDB (MySQL compatible)
- **Architecture**: Single container for reliability
- **Port Forwarding**: Automatic for web services
- **Auto-start**: All services initialize on Codespace creation

---

**Happy Coding! 🎉**  
*Iligan Computer Institute - IT Department*
