# 🚀 Basic PHP & MySQL Environment for GitHub Codespaces

A simple, focused **PHP 8.1+** and **MySQL 8.0+** development environment designed specifically for **GitHub Codespaces**. Perfect for students learning the fundamentals of PHP and MySQL without unnecessary complexity.

## ✨ What's Included

### 🛠️ Essential Components
- **PHP 8.1** with essential extensions (PDO, MySQLi)
- **MySQL 8.0** with sample database
- **Apache 2.4** web server
- **phpMyAdmin** for database management

### 🎓 Learning-Focused Features
- Simple, clean interface
- Pre-configured sample database with data
- Basic CRUD demo application
- No complex configurations to learn
- Focus on PHP and MySQL fundamentals

## 🚀 Quick Start

### 1. Create Your Environment
1. **Fork this repository** to your GitHub account
2. **Click "Code" → "Create codespace on main"**
3. **Wait 2-3 minutes** for automatic setup
4. **Start coding!** Everything is ready to use

### 2. Access Your Environment

**In GitHub Codespaces, services are automatically forwarded with unique URLs:**

| Service | Port | How to Access |
|---------|------|---------------|
| **Your Website** | 80 | Click the "Open in Browser" button when port 80 is forwarded |
| **phpMyAdmin** | 8080 | Click the "Open in Browser" button when port 8080 is forwarded |
| **MySQL** | 3306 | Use `mysql` as hostname in your PHP code (auto-forwarded) |

**📌 Important for Codespaces:**
- Don't use `localhost:8080` - use the forwarded URL provided by Codespaces
- Look for notification popups saying "Your application is available on port X"
- You can also access forwarded ports via the "Ports" tab in VS Code

## 📋 Database Setup

### Connection Details
```php
// Connect to your database
$host = 'mysql';
$database = 'basic_db';
$username = 'root';      // or 'student'
$password = 'root';      // or 'student'

$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
```

### Sample Data
Your environment comes with:
- A `users` table with sample data
- Basic database structure for learning
- Two user accounts: `root/root` and `student/student`

## 📁 File Structure

```
/var/www/html/          ← Your web root (put PHP files here)
├── index.php           ← Welcome page
├── db-test.php         ← Test database connection
├── simple-crud.php     ← Simple CRUD example
└── phpinfo.php         ← PHP configuration info
```

## 💻 Learning Examples

### 1. Basic Database Connection
```php
<?php
try {
    $pdo = new PDO("mysql:host=mysql;dbname=basic_db", "root", "root");
    echo "Connected to database!";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
```

### 2. Simple Query
```php
<?php
$pdo = new PDO("mysql:host=mysql;dbname=basic_db", "root", "root");
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();

foreach ($users as $user) {
    echo $user['name'] . " - " . $user['email'] . "<br>";
}
?>
```

### 3. Insert Data
```php
<?php
$pdo = new PDO("mysql:host=mysql;dbname=basic_db", "root", "root");
$stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
$stmt->execute(['John Doe', 'john@example.com']);
echo "User added!";
?>
```

## 🎯 What You Can Learn

### PHP Basics
- Variables and data types
- Control structures (if, for, while)
- Functions and arrays
- Form handling
- File inclusion

### Database Fundamentals
- Connecting to MySQL
- SELECT, INSERT, UPDATE, DELETE operations
- Prepared statements for security
- Basic database design

### Web Development
- HTML and PHP integration
- Processing form data
- Session management
- Basic security practices

## 🛠️ Development Workflow

1. **Write PHP code** in `/var/www/html/`
2. **View your work** through port 80 forwarding
3. **Manage database** with phpMyAdmin (port 8080)
4. **Test connections** with the built-in test page

## 🎓 For Educators

### Why This Setup?
- **No Installation Hassles**: Works in any web browser
- **Consistent Environment**: Every student has identical setup
- **Focus on Learning**: No time wasted on configuration
- **Immediate Results**: Students can see their code work instantly
- **Easy Sharing**: Just share the repository link

### Classroom Use
- Students fork the repository
- Create their own Codespace
- Start learning immediately
- Share work through GitHub
- No "it works on my machine" problems

## 🔧 Quick Commands

### Check Service Status
```bash
docker-compose ps
```

### View Logs
```bash
docker-compose logs
```

### Restart Services
```bash
docker-compose restart
```

### Access MySQL Command Line
```bash
docker-compose exec mysql mysql -u root -p
```

## 🐛 Troubleshooting

### Services Not Starting?
- Wait 2-3 minutes for full initialization
- Check the terminal for startup messages
- Refresh your browser

### Docker Build Issues?
✅ **Fixed!** This environment now uses pre-built `webdevops/php-apache:8.1` image instead of building from scratch, which eliminates common compilation errors and speeds up deployment.

### Can't Connect to Database?
- Ensure you're using `mysql` as the host (not `localhost`)
- Wait for MySQL to fully start (can take 1-2 minutes)
- Check credentials: `root/root` or `student/student`

### phpMyAdmin Not Working?
✅ **Fixed for Codespaces!** phpMyAdmin now includes proper configuration for GitHub Codespaces' subdomain system.

**How to Access phpMyAdmin:**
1. Wait for all services to start (2-3 minutes)
2. Look for the "Port 8080" notification in VS Code
3. Click "Open in Browser" when the port 8080 notification appears
4. Or check the "Ports" tab and click the globe icon next to port 8080

**Login Credentials:**
- Username: `root`
- Password: `root`

**Still having issues?**
- Make sure you're using the Codespaces forwarded URL, not `localhost:8080`
- Wait for MySQL to be fully ready before accessing phpMyAdmin
- Check that all containers are running: View → Terminal → New Terminal → `docker-compose ps`

## � Next Steps

Once you're comfortable with the basics:

1. **Learn PHP Frameworks**: Try Laravel or CodeIgniter
2. **Add Frontend**: Learn JavaScript and CSS
3. **Security**: Study prepared statements and validation
4. **Advanced MySQL**: Explore joins, indexes, and optimization
5. **Version Control**: Use Git for your projects

## 🤝 Contributing

Found a bug or have a suggestion? 
- Open an [Issue](https://github.com/your-username/repository/issues)
- Submit a [Pull Request](https://github.com/your-username/repository/pulls)

## 📄 License

This project is open source and available under the MIT License.

---

**Ready to start learning PHP and MySQL? 🎉**

*This environment removes all the complexity and lets you focus on what matters: learning to code!*
