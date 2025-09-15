#!/bin/bash

echo "🚀 Setting up XAMPP-like environment for GitHub Codespaces..."

# Create necessary directories
mkdir -p /var/www/html/logs
mkdir -p /var/www/html/tmp

# Set proper permissions
sudo chown -R vscode:www-data /var/www/html
sudo chmod -R 755 /var/www/html

# Create phpinfo file
cat > /var/www/html/phpinfo.php << 'EOF'
<?php
phpinfo();
?>
EOF

# Create sample database connection test
cat > /var/www/html/db-test.php << 'EOF'
<?php
echo "<h1>Database Connection Test</h1>";

$servername = "mysql";
$username = "root";
$password = "root";
$dbname = "test_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color: green;'>✅ Connected successfully to MySQL database!</p>";
    
    // Test query
    $stmt = $pdo->query("SELECT VERSION() as version");
    $version = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p><strong>MySQL Version:</strong> " . $version['version'] . "</p>";
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>❌ Connection failed: " . $e->getMessage() . "</p>";
}

echo "<h2>Environment Information</h2>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>Server:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";

echo '<h2>Quick Links</h2>';
echo '<ul>';
echo '<li><a href="/phpinfo.php">PHP Info</a></li>';
echo '<li><a href="/phpmyadmin/">phpMyAdmin</a></li>';
echo '<li><a href="/sample.php">Sample PHP Page</a></li>';
echo '</ul>';
?>
EOF

# Create sample PHP page
cat > /var/www/html/sample.php << 'EOF'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XAMPP-like Environment - Sample Page</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .header { background: #f0f8ff; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .info { background: #e7f3ff; padding: 15px; border-left: 4px solid #2196F3; margin: 10px 0; }
        .success { background: #e8f5e8; padding: 15px; border-left: 4px solid #4caf50; margin: 10px 0; }
        .code { background: #f5f5f5; padding: 10px; border-radius: 4px; font-family: monospace; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚀 Welcome to Your XAMPP-like Environment!</h1>
        <p>GitHub Codespaces • PHP <?= phpversion() ?> • MySQL 8.0+ • phpMyAdmin</p>
    </div>

    <div class="success">
        <h3>✅ Environment Status</h3>
        <p>Your development environment is running successfully!</p>
    </div>

    <div class="info">
        <h3>📋 Environment Details</h3>
        <table>
            <tr><th>Component</th><th>Version/Status</th><th>Access</th></tr>
            <tr><td>PHP</td><td><?= phpversion() ?></td><td><a href="/phpinfo.php">View PHP Info</a></td></tr>
            <tr><td>Apache</td><td><?= $_SERVER['SERVER_SOFTWARE'] ?></td><td>Port 80 & 443</td></tr>
            <tr><td>MySQL</td><td><?php 
                try {
                    $pdo = new PDO("mysql:host=mysql", "root", "root");
                    $stmt = $pdo->query("SELECT VERSION()");
                    echo $stmt->fetchColumn();
                } catch(Exception $e) {
                    echo "Connection issue";
                }
            ?></td><td>Port 3306</td></tr>
            <tr><td>phpMyAdmin</td><td>Latest</td><td><a href="/phpmyadmin/">Access phpMyAdmin</a></td></tr>
        </table>
    </div>

    <div class="info">
        <h3>🔧 Database Connection Details</h3>
        <div class="code">
            Host: mysql (internal) or localhost:3306 (external)<br>
            Username: root<br>
            Password: root<br>
            Database: test_db<br><br>
            Alternative User:<br>
            Username: xampp<br>
            Password: xampp
        </div>
    </div>

    <div class="info">
        <h3>📁 File Structure</h3>
        <div class="code">
            /var/www/html/ - Your web root<br>
            ├── index.php - This page<br>
            ├── phpinfo.php - PHP configuration<br>
            ├── db-test.php - Database test<br>
            └── phpmyadmin/ - Database management
        </div>
    </div>

    <div class="info">
        <h3>🎯 Quick Tests</h3>
        <ul>
            <li><a href="/db-test.php">Test Database Connection</a></li>
            <li><a href="/phpinfo.php">View PHP Configuration</a></li>
            <li><a href="/phpmyadmin/">Access Database Manager</a></li>
        </ul>
    </div>

    <div class="info">
        <h3>💡 Development Tips</h3>
        <ul>
            <li>All your PHP files should be placed in <code>/var/www/html/</code></li>
            <li>The environment auto-starts when the Codespace launches</li>
            <li>Database data persists between Codespace sessions</li>
            <li>Use the integrated terminal for command-line operations</li>
            <li>Xdebug is configured for debugging (port 9003)</li>
        </ul>
    </div>

    <hr>
    <p><em>Generated on <?= date('Y-m-d H:i:s') ?> • Environment: GitHub Codespaces</em></p>
</body>
</html>
EOF

# Create index.php that points to sample.php
cat > /var/www/html/index.php << 'EOF'
<?php
// Redirect to sample.php for the welcome page
header('Location: /sample.php');
exit();
?>
EOF

echo "✅ Setup completed successfully!"
echo "📂 Files created in /var/www/html/"
echo "🌐 Visit your site at the forwarded port to see the welcome page"
