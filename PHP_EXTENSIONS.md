# PHP Extensions Reference

## 📦 Essential Extensions Included

This XAMPP-like environment includes only the most essential PHP extensions needed for web development:

### Database Extensions
- **PDO** - PHP Data Objects (recommended for database connections)
- **MySQLi** - MySQL Improved extension
- **pdo_mysql** - PDO driver for MySQL

### Core Extensions
- **mbstring** - Multi-byte string handling (UTF-8 support)
- **GD** - Image processing library (JPEG, PNG, GIF support)
- **ZIP** - Archive handling

## 🎯 Why Only Essential Extensions?

1. **Faster Build Times** - Fewer extensions mean quicker container builds
2. **Smaller Image Size** - Reduced disk space usage
3. **Educational Focus** - Students learn core PHP development without complexity
4. **Stability** - Fewer dependencies reduce potential conflicts

## 📚 What Each Extension Does

### PDO (PHP Data Objects)
```php
// Modern database connections
$pdo = new PDO("mysql:host=mysql;dbname=xampp", "root", "xampp");
```

### MySQLi
```php
// Traditional MySQL connections
$conn = mysqli_connect("mysql", "root", "xampp", "xampp");
```

### mbstring
```php
// UTF-8 string handling
echo mb_strlen("Hello 世界"); // Works with international characters
```

### GD
```php
// Image processing
$image = imagecreate(100, 100);
imagepng($image, 'output.png');
```

### ZIP
```php
// Archive handling
$zip = new ZipArchive();
$zip->open('archive.zip', ZipArchive::CREATE);
```

## 🔧 Need Additional Extensions?

If you need additional PHP extensions for your project, you can:

1. **Edit the Dockerfile** - Add extensions to the `docker-php-ext-install` command
2. **Use PECL** - For extensions not included in core PHP
3. **Ask Your Instructor** - For course-specific extension requirements

### Example: Adding curl extension
```dockerfile
# In Dockerfile, modify this line:
RUN docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    mysqli \
    mbstring \
    gd \
    zip \
    curl
```

## ✅ Verification

You can check which extensions are loaded by:
1. Visiting `/index.php` to see phpinfo()
2. Using PHP command line: `php -m`
3. Checking in your PHP code: `extension_loaded('extension_name')`

---

This minimal setup ensures fast, reliable PHP development while covering 95% of typical web development needs!
