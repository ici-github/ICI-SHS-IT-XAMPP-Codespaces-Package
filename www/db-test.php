<?php
/**
 * Database Connection Test Page
 * Tests MySQL connectivity and displays environment information
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Test - XAMPP Environment</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .header { background: #2196F3; color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
        .result { padding: 15px; margin: 15px 0; border-radius: 6px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background: #e2e3e5; color: #383d41; border: 1px solid #d6d8db; }
        .code { background: #f8f9fa; padding: 10px; border-radius: 4px; font-family: monospace; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        .btn { display: inline-block; padding: 8px 16px; background: #2196F3; color: white; text-decoration: none; border-radius: 4px; margin: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔍 Database Connection Test</h1>
        <p>Testing MySQL connectivity and environment status</p>
    </div>

    <div style="margin-bottom: 20px;">
        <a href="/" class="btn">🏠 Home</a>
        <a href="/phpmyadmin/" class="btn">🗃️ phpMyAdmin</a>
        <a href="/phpinfo.php" class="btn">📋 PHP Info</a>
    </div>

    <?php
    echo '<div class="result info">';
    echo '<h3>📊 Environment Information</h3>';
    echo '<table>';
    echo '<tr><th>Component</th><th>Value</th></tr>';
    echo '<tr><td>PHP Version</td><td>' . phpversion() . '</td></tr>';
    echo '<tr><td>Server Software</td><td>' . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . '</td></tr>';
    echo '<tr><td>Document Root</td><td>' . $_SERVER['DOCUMENT_ROOT'] . '</td></tr>';
    echo '<tr><td>Current Time</td><td>' . date('Y-m-d H:i:s') . '</td></tr>';
    echo '<tr><td>Server Name</td><td>' . ($_SERVER['SERVER_NAME'] ?? 'localhost') . '</td></tr>';
    echo '</table>';
    echo '</div>';

    // Test database connection
    echo '<div class="result">';
    echo '<h3>🗄️ MySQL Connection Test</h3>';
    
    try {
        $pdo = new PDO("mysql:host=mysql;dbname=test_db", "root", "root");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo '<div class="success">';
        echo '<h4>✅ Connection Successful!</h4>';
        echo '<p>Successfully connected to MySQL database.</p>';
        
        // Get MySQL version
        $stmt = $pdo->query("SELECT VERSION() as version");
        $version = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '<p><strong>MySQL Version:</strong> ' . $version['version'] . '</p>';
        
        // Test database operations
        echo '<h4>📊 Database Information</h4>';
        echo '<table>';
        
        // Show databases
        $stmt = $pdo->query("SHOW DATABASES");
        $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo '<tr><td>Available Databases</td><td>' . implode(', ', $databases) . '</td></tr>';
        
        // Show tables in test_db
        $stmt = $pdo->query("SHOW TABLES FROM test_db");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo '<tr><td>Tables in test_db</td><td>' . (empty($tables) ? 'No tables' : implode(', ', $tables)) . '</td></tr>';
        
        // Count users if table exists
        if (in_array('users', $tables)) {
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
            $userCount = $stmt->fetchColumn();
            echo '<tr><td>Users Count</td><td>' . $userCount . ' users</td></tr>';
        }
        
        // Count posts if table exists
        if (in_array('posts', $tables)) {
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM posts");
            $postCount = $stmt->fetchColumn();
            echo '<tr><td>Posts Count</td><td>' . $postCount . ' posts</td></tr>';
        }
        
        echo '</table>';
        echo '</div>';
        
    } catch(PDOException $e) {
        echo '<div class="error">';
        echo '<h4>❌ Connection Failed</h4>';
        echo '<p><strong>Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '<p>This might happen if MySQL is still starting up. Please wait a moment and refresh.</p>';
        echo '</div>';
    }
    echo '</div>';

    // Show sample connection code
    echo '<div class="result info">';
    echo '<h3>💻 Sample Connection Code</h3>';
    echo '<div class="code">';
    echo htmlspecialchars('<?php
// Database connection for your applications
try {
    $pdo = new PDO("mysql:host=mysql;dbname=test_db", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>');
    echo '</div>';
    echo '</div>';

    // PHP extensions
    echo '<div class="result info">';
    echo '<h3>🔧 Loaded PHP Extensions</h3>';
    $extensions = get_loaded_extensions();
    sort($extensions);
    echo '<p>' . implode(', ', $extensions) . '</p>';
    echo '</div>';
    ?>

    <footer style="margin-top: 30px; padding: 20px; text-align: center; color: #666;">
        <hr>
        <p>Database Test • XAMPP-like Environment • Generated on <?= date('Y-m-d H:i:s') ?></p>
    </footer>
</body>
</html>
