<?php
// Database Connection Test
// This file tests the MySQL database connection and displays database information

$host = 'mysql';
$username = 'root';
$password = 'xampp';
$database = 'xampp';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Test - XAMPP Environment</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: #f5f7fa; 
        }
        .container { 
            max-width: 800px; 
            margin: 0 auto; 
            background: white; 
            border-radius: 10px; 
            padding: 30px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        h1 { 
            color: #333; 
            text-align: center; 
            margin-bottom: 30px;
        }
        .nav {
            text-align: center;
            margin-bottom: 30px;
        }
        .nav a {
            color: #667eea;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
        }
        .nav a:hover {
            text-decoration: underline;
        }
        .status {
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: bold;
        }
        .success {
            background: #c6f6d5;
            color: #22543d;
            border: 1px solid #9ae6b4;
        }
        .error {
            background: #fed7d7;
            color: #742a2a;
            border: 1px solid #feb2b2;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .info-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .info-card strong {
            color: #4a5568;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e1e8ed;
        }
        th {
            background: #f8f9fa;
            font-weight: 600;
            color: #4a5568;
        }
        tr:hover {
            background: #f8f9fa;
        }
        .code-sample {
            background: #2d3748;
            color: #e2e8f0;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            overflow-x: auto;
        }
        .code-sample pre {
            margin: 0;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="welcome.html">← Back to Welcome</a> |
            <a href="index.php">PHP Info</a> |
            <a href="sample-app.php">Sample App</a> |
            <a href="http://localhost:8080" target="_blank">phpMyAdmin</a>
        </div>
        
        <h1>🗄️ Database Connection Test</h1>

        <?php
        try {
            // Attempt to connect to MySQL
            $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            echo '<div class="status success">✅ Database Connection Successful!</div>';
            
            // Get MySQL version
            $stmt = $pdo->query('SELECT VERSION() as version');
            $version = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Get current database
            $stmt = $pdo->query('SELECT DATABASE() as current_db');
            $current_db = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Connection information
            echo '<div class="info-grid">';
            echo '<div class="info-card"><strong>Host:</strong> ' . htmlspecialchars($host) . '</div>';
            echo '<div class="info-card"><strong>Database:</strong> ' . htmlspecialchars($current_db['current_db']) . '</div>';
            echo '<div class="info-card"><strong>MySQL Version:</strong> ' . htmlspecialchars($version['version']) . '</div>';
            echo '<div class="info-card"><strong>Character Set:</strong> UTF-8</div>';
            echo '</div>';
            
            // Show available databases
            $stmt = $pdo->query('SHOW DATABASES');
            $databases = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo '<h3>📚 Available Databases:</h3>';
            echo '<table>';
            echo '<thead><tr><th>Database Name</th><th>Description</th></tr></thead>';
            echo '<tbody>';
            
            foreach ($databases as $db) {
                $db_name = $db['Database'];
                $description = '';
                
                switch ($db_name) {
                    case 'xampp':
                        $description = 'Main application database with sample data';
                        break;
                    case 'student_projects':
                        $description = 'Database for student projects';
                        break;
                    case 'information_schema':
                        $description = 'MySQL system database (metadata)';
                        break;
                    case 'performance_schema':
                        $description = 'MySQL performance monitoring';
                        break;
                    case 'mysql':
                        $description = 'MySQL system database';
                        break;
                    case 'sys':
                        $description = 'MySQL system views and procedures';
                        break;
                    default:
                        $description = 'User database';
                }
                
                echo '<tr>';
                echo '<td><strong>' . htmlspecialchars($db_name) . '</strong></td>';
                echo '<td>' . htmlspecialchars($description) . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
            
            // Show tables in current database
            $stmt = $pdo->query('SHOW TABLES');
            $tables = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($tables)) {
                echo '<h3>📋 Tables in "' . htmlspecialchars($database) . '" Database:</h3>';
                echo '<table>';
                echo '<thead><tr><th>Table Name</th><th>Row Count</th></tr></thead>';
                echo '<tbody>';
                
                foreach ($tables as $table) {
                    $table_name = $table['Tables_in_' . $database];
                    
                    // Get row count
                    $count_stmt = $pdo->query("SELECT COUNT(*) as count FROM `$table_name`");
                    $count = $count_stmt->fetch(PDO::FETCH_ASSOC);
                    
                    echo '<tr>';
                    echo '<td><strong>' . htmlspecialchars($table_name) . '</strong></td>';
                    echo '<td>' . number_format($count['count']) . ' rows</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            }
            
            // Show sample data from sample_users table if it exists
            try {
                $stmt = $pdo->query('SELECT * FROM sample_users LIMIT 5');
                $sample_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (!empty($sample_users)) {
                    echo '<h3>👥 Sample Data from "sample_users" Table:</h3>';
                    echo '<table>';
                    echo '<thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Created At</th></tr></thead>';
                    echo '<tbody>';
                    
                    foreach ($sample_users as $user) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($user['id']) . '</td>';
                        echo '<td>' . htmlspecialchars($user['username']) . '</td>';
                        echo '<td>' . htmlspecialchars($user['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($user['created_at']) . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                }
            } catch (PDOException $e) {
                // Table doesn't exist, that's okay
            }
            
        } catch(PDOException $e) {
            echo '<div class="status error">❌ Connection Failed!</div>';
            echo '<p><strong>Error Message:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
            
            echo '<h3>Troubleshooting Tips:</h3>';
            echo '<ul>';
            echo '<li>Make sure MySQL container is running</li>';
            echo '<li>Check if the database credentials are correct</li>';
            echo '<li>Verify that the host is "mysql" (not "localhost")</li>';
            echo '<li>Ensure the database exists</li>';
            echo '</ul>';
        }
        ?>
        
        <h3>🔧 Connection Code Sample:</h3>
        <div class="code-sample">
            <pre><?php echo htmlspecialchars('<?php
$host = \'mysql\';  // Use \'mysql\' in Codespaces
$username = \'root\';
$password = \'xampp\';
$database = \'xampp\';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>'); ?></pre>
        </div>
        
        <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
            <h3>🎓 Learning Notes:</h3>
            <ul>
                <li>Always use <strong>"mysql"</strong> as the hostname in Codespaces (not "localhost")</li>
                <li>PDO is the recommended way to connect to databases in PHP</li>
                <li>Always use prepared statements for security</li>
                <li>Enable error reporting for debugging: <code>PDO::ATTR_ERRMODE</code></li>
                <li>Set charset to UTF-8 for proper character handling</li>
            </ul>
        </div>
    </div>
</body>
</html>
