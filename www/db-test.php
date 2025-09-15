<?php
/**
 * Simple Database Connection Test
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Test</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 800px; 
            margin: 50px auto; 
            padding: 20px;
            background: #f4f4f4;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header { 
            text-align: center;
            color: #333;
            border-bottom: 2px solid #007cba;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .result { 
            padding: 15px; 
            margin: 15px 0; 
            border-radius: 6px; 
        }
        .success { 
            background: #d4edda; 
            color: #155724; 
            border: 1px solid #c3e6cb; 
        }
        .error { 
            background: #f8d7da; 
            color: #721c24; 
            border: 1px solid #f5c6cb; 
        }
        .info { 
            background: #e2e3e5; 
            color: #383d41; 
            border: 1px solid #d6d8db; 
        }
        .code { 
            background: #f8f9fa; 
            padding: 10px; 
            border-radius: 4px; 
            font-family: monospace; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 15px 0; 
        }
        th, td { 
            padding: 10px; 
            text-align: left; 
            border-bottom: 1px solid #ddd; 
        }
        th { background-color: #f8f9fa; }
        .btn { 
            display: inline-block; 
            padding: 8px 16px; 
            background: #007cba; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px; 
            margin: 5px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔍 Database Connection Test</h1>
            <p>Testing MySQL connectivity</p>
        </div>

        <div style="margin-bottom: 20px;">
            <a href="/" class="btn">🏠 Home</a>
            <a href="/simple-crud.php" class="btn">� CRUD Demo</a>
            <a href="http://localhost:8080" target="_blank" class="btn">�️ phpMyAdmin</a>
        </div>

        <div class="result info">
            <h3>📊 Environment Information</h3>
            <table>
                <tr><th>Component</th><th>Value</th></tr>
                <tr><td>PHP Version</td><td><?= phpversion() ?></td></tr>
                <tr><td>Server</td><td><?= $_SERVER['SERVER_SOFTWARE'] ?? 'Apache' ?></td></tr>
                <tr><td>Current Time</td><td><?= date('Y-m-d H:i:s') ?></td></tr>
            </table>
        </div>

        <?php
        // Test database connection
        echo '<div class="result">';
        echo '<h3>🗄️ MySQL Connection Test</h3>';
        
        try {
            $pdo = new PDO("mysql:host=mysql;dbname=basic_db", "root", "root");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            echo '<div class="success">';
            echo '<h4>✅ Connection Successful!</h4>';
            echo '<p>Successfully connected to MySQL database.</p>';
            
            // Get MySQL version
            $stmt = $pdo->query("SELECT VERSION() as version");
            $version = $stmt->fetch(PDO::FETCH_ASSOC);
            echo '<p><strong>MySQL Version:</strong> ' . $version['version'] . '</p>';
            
            // Test basic operations
            echo '<h4>📊 Database Information</h4>';
            echo '<table>';
            
            // Show current database
            $stmt = $pdo->query("SELECT DATABASE() as current_db");
            $current_db = $stmt->fetch(PDO::FETCH_ASSOC);
            echo '<tr><td>Current Database</td><td>' . $current_db['current_db'] . '</td></tr>';
            
            // Count users
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
            $userCount = $stmt->fetchColumn();
            echo '<tr><td>Users in Database</td><td>' . $userCount . ' users</td></tr>';
            
            // Show sample users
            if ($userCount > 0) {
                $stmt = $pdo->query("SELECT name, email FROM users LIMIT 3");
                $sampleUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $userList = [];
                foreach ($sampleUsers as $user) {
                    $userList[] = $user['name'] . ' (' . $user['email'] . ')';
                }
                echo '<tr><td>Sample Users</td><td>' . implode('<br>', $userList) . '</td></tr>';
            }
            
            echo '</table>';
            echo '</div>';
            
        } catch(PDOException $e) {
            echo '<div class="error">';
            echo '<h4>❌ Connection Failed</h4>';
            echo '<p><strong>Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '<p>MySQL might still be starting up. Please wait a moment and refresh.</p>';
            echo '</div>';
        }
        echo '</div>';
        ?>

        <div class="result info">
            <h3>💻 Sample Connection Code</h3>
            <div class="code">
&lt;?php
// Basic database connection
try {
    $pdo = new PDO("mysql:host=mysql;dbname=basic_db", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?&gt;
            </div>
        </div>

        <div class="result info">
            <h3>🔧 Connection Details</h3>
            <table>
                <tr><td>Host</td><td>mysql</td></tr>
                <tr><td>Database</td><td>basic_db</td></tr>
                <tr><td>Username</td><td>root (or student)</td></tr>
                <tr><td>Password</td><td>root (or student)</td></tr>
                <tr><td>Port</td><td>3306</td></tr>
            </table>
        </div>

        <footer style="text-align: center; margin-top: 30px; color: #666;">
            <hr>
            <p>Database Test • Generated on <?= date('Y-m-d H:i:s') ?></p>
        </footer>
    </div>
</body>
</html>
