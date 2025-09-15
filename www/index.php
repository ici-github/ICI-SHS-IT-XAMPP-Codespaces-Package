<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XAMPP-like Environment</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 20px;
            line-height: 1.6;
        }
        .header { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px; 
            border-radius: 10px; 
            margin-bottom: 30px;
            text-align: center;
        }
        .card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .success { border-left: 4px solid #4caf50; background: #f1f8e9; }
        .info { border-left: 4px solid #2196F3; background: #e3f2fd; }
        .warning { border-left: 4px solid #ff9800; background: #fff3e0; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #2196F3;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
        }
        .btn:hover { background: #1976D2; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; }
        .code { 
            background: #f5f5f5; 
            padding: 15px; 
            border-radius: 5px; 
            font-family: monospace;
            overflow-x: auto;
        }
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
        }
        .status-online { background: #4caf50; }
        .status-offline { background: #f44336; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚀 XAMPP-like Development Environment</h1>
        <p>GitHub Codespaces • PHP <?= phpversion() ?> • MySQL 8.0+ • Apache • phpMyAdmin</p>
        <p><em>Ready for your students to develop anywhere, anytime!</em></p>
    </div>

    <div class="grid">
        <div class="card success">
            <h3>✅ Environment Status</h3>
            <p>Your XAMPP-like development environment is running successfully!</p>
            <table>
                <tr>
                    <td><span class="status-indicator status-online"></span>PHP</td>
                    <td><?= phpversion() ?></td>
                </tr>
                <tr>
                    <td><span class="status-indicator status-online"></span>Apache</td>
                    <td><?= $_SERVER['SERVER_SOFTWARE'] ?? 'Apache/2.4+' ?></td>
                </tr>
                <tr>
                    <td><span class="status-indicator <?php 
                        try {
                            $pdo = new PDO("mysql:host=mysql", "root", "root");
                            echo "status-online";
                        } catch(Exception $e) {
                            echo "status-offline";
                        }
                    ?>"></span>MySQL</td>
                    <td><?php 
                        try {
                            $pdo = new PDO("mysql:host=mysql", "root", "root");
                            $stmt = $pdo->query("SELECT VERSION()");
                            echo $stmt->fetchColumn();
                        } catch(Exception $e) {
                            echo "Connecting...";
                        }
                    ?></td>
                </tr>
            </table>
        </div>

        <div class="card info">
            <h3>🔗 Quick Access</h3>
            <a href="/phpinfo.php" class="btn">📋 PHP Info</a>
            <a href="/phpmyadmin/" class="btn">🗃️ phpMyAdmin</a>
            <a href="/db-test.php" class="btn">🔍 DB Test</a>
            <a href="/sample-crud.php" class="btn">📝 CRUD Demo</a>
        </div>
    </div>

    <div class="card info">
        <h3>🎓 For Students & Educators</h3>
        <div class="grid">
            <div>
                <h4>🏫 Perfect for Learning</h4>
                <ul>
                    <li>Complete LAMP stack environment</li>
                    <li>Pre-configured PHP 8.1+ with extensions</li>
                    <li>MySQL 8.0+ with sample database</li>
                    <li>phpMyAdmin for database management</li>
                    <li>Works in any web browser</li>
                    <li>No local installation required</li>
                </ul>
            </div>
            <div>
                <h4>🛠️ Development Features</h4>
                <ul>
                    <li>Xdebug for debugging</li>
                    <li>Composer for dependency management</li>
                    <li>All major PHP extensions</li>
                    <li>Apache with mod_rewrite</li>
                    <li>SSL support (HTTPS)</li>
                    <li>File upload support</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card info">
        <h3>🔧 Database Connection Details</h3>
        <div class="code">
<strong>For PHP Applications:</strong>
$host = 'mysql';           // Internal container name
$username = 'root';
$password = 'root';
$database = 'test_db';

<strong>For External Connections:</strong>
Host: localhost:3306       // Through port forwarding
Username: root / xampp
Password: root / xampp
Database: test_db
        </div>
    </div>

    <div class="card info">
        <h3>📁 Project Structure</h3>
        <div class="code">
/var/www/html/             ← Your web root directory
├── index.php             ← This welcome page
├── phpinfo.php           ← PHP configuration
├── db-test.php           ← Database connection test
├── sample-crud.php       ← CRUD operations demo
└── phpmyadmin/          ← Database management interface

/config/                   ← Configuration files
├── php/php.ini           ← PHP configuration
├── mysql/my.cnf          ← MySQL configuration
└── apache/               ← Apache virtual hosts

/scripts/                  ← Setup and utility scripts
        </div>
    </div>

    <div class="card warning">
        <h3>💡 Getting Started Tips</h3>
        <ol>
            <li><strong>Upload your files:</strong> Place PHP files in <code>/var/www/html/</code></li>
            <li><strong>Database access:</strong> Use phpMyAdmin or connect via PHP</li>
            <li><strong>Port forwarding:</strong> Codespaces automatically forwards ports 80, 443, and 3306</li>
            <li><strong>File permissions:</strong> Files are automatically given correct permissions</li>
            <li><strong>Debugging:</strong> Xdebug is pre-configured on port 9003</li>
            <li><strong>Logs:</strong> Check <code>docker-compose logs</code> for troubleshooting</li>
        </ol>
    </div>

    <div class="card success">
        <h3>📊 Sample Database Content</h3>
        <?php
        try {
            $pdo = new PDO("mysql:host=mysql;dbname=test_db", "root", "root");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            echo "<p>✅ Connected to sample database 'test_db'</p>";
            
            // Show users
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
            $userCount = $stmt->fetchColumn();
            
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM posts");
            $postCount = $stmt->fetchColumn();
            
            echo "<p><strong>Sample data available:</strong></p>";
            echo "<ul>";
            echo "<li>👥 {$userCount} users in the users table</li>";
            echo "<li>📝 {$postCount} posts in the posts table</li>";
            echo "</ul>";
            
        } catch(PDOException $e) {
            echo "<p style='color: #f44336;'>⏳ Database is starting up... Please refresh in a moment.</p>";
        }
        ?>
    </div>

    <footer style="margin-top: 50px; padding: 20px; text-align: center; color: #666;">
        <hr>
        <p><strong>XAMPP-like Environment for GitHub Codespaces</strong></p>
        <p>Generated on <?= date('Y-m-d H:i:s') ?> • Environment: GitHub Codespaces</p>
        <p><em>Perfect for students and educators who need a complete web development environment!</em></p>
    </footer>
</body>
</html>
