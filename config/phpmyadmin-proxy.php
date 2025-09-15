<?php
/**
 * phpMyAdmin Proxy for GitHub Codespaces
 * This file provides access to phpMyAdmin through the /phpmyadmin path
 */

// Get Codespaces environment variables
$codespace_name = getenv('CODESPACE_NAME');
$github_codespaces_port_forwarding_domain = getenv('GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN');

// Determine phpMyAdmin URL
if ($codespace_name && $github_codespaces_port_forwarding_domain) {
    // Codespaces environment - use port 8080 forwarding
    $phpmyadmin_url = "https://{$codespace_name}-8080.{$github_codespaces_port_forwarding_domain}";
} else {
    // Local development
    $phpmyadmin_url = "http://localhost:8080";
}

// Get the current request path and query string
$request_path = $_SERVER['REQUEST_URI'];
$request_path = preg_replace('#^/phpmyadmin/?#', '/', $request_path);
$query_string = $_SERVER['QUERY_STRING'] ?? '';

// Build target URL
$target_url = $phpmyadmin_url . ltrim($request_path, '/');
if ($query_string) {
    $target_url .= '?' . $query_string;
}

// For HTML responses, try to proxy the content
if (!isset($_GET['direct']) && strpos($target_url, '.css') === false && strpos($target_url, '.js') === false && strpos($target_url, '.png') === false && strpos($target_url, '.jpg') === false && strpos($target_url, '.gif') === false) {
    
    // Set up curl to fetch the content
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $target_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] ?? 'phpMyAdmin Proxy');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    // Forward headers
    $headers = [];
    foreach ($_SERVER as $key => $value) {
        if (strpos($key, 'HTTP_') === 0 && !in_array($key, ['HTTP_HOST', 'HTTP_CONNECTION'])) {
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[] = $header . ': ' . $value;
        }
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    // Handle POST data
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents('php://input'));
    }
    
    // Execute request
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    
    if ($response !== false && $http_code == 200) {
        // Set content type
        if ($content_type) {
            header('Content-Type: ' . $content_type);
        }
        
        // For HTML content, rewrite URLs to use the proxy
        if (strpos($content_type, 'text/html') !== false) {
            $response = preg_replace(
                '#(href|src|action)="([^"]*)"#',
                '$1="/phpmyadmin$2"',
                $response
            );
            $response = str_replace('="/phpmyadmin/"', '="/phpmyadmin/"', $response);
            $response = str_replace('="/phpmyadmin//"', '="/phpmyadmin/"', $response);
        }
        
        echo $response;
        curl_close($ch);
        exit;
    }
    
    curl_close($ch);
}

// Fallback: redirect to direct access or show info page
?>
<!DOCTYPE html>
<html>
<head>
    <title>phpMyAdmin Access - XAMPP Environment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            margin: 0; padding: 20px; background: #f5f5f5; 
        }
        .container { 
            max-width: 800px; margin: 0 auto; background: white; 
            border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        }
        .header { 
            background: linear-gradient(135deg, #b92b27 0%, #1565C0 100%); 
            color: white; padding: 30px; border-radius: 8px 8px 0 0; text-align: center; 
        }
        .content { padding: 30px; }
        .info-box { 
            background: #e3f2fd; padding: 20px; border-radius: 6px; 
            border-left: 4px solid #2196F3; margin: 20px 0; 
        }
        .success-box { 
            background: #e8f5e8; padding: 20px; border-radius: 6px; 
            border-left: 4px solid #4caf50; margin: 20px 0; 
        }
        .button { 
            display: inline-block; padding: 12px 24px; background: #2196F3; 
            color: white; text-decoration: none; border-radius: 6px; 
            margin: 10px 5px; font-weight: 500; 
        }
        .button:hover { background: #1976D2; }
        .button-success { background: #4caf50; }
        .button-success:hover { background: #388e3c; }
        .code { 
            background: #f8f8f8; padding: 15px; border-radius: 6px; 
            font-family: monospace; font-size: 14px; margin: 15px 0;
            border: 1px solid #e0e0e0;
        }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0; }
        @media (max-width: 768px) { .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🗃️ phpMyAdmin Access</h1>
            <p>Database Management for Your XAMPP Environment</p>
        </div>
        
        <div class="content">
            <div class="success-box">
                <h3>✅ Environment Ready</h3>
                <p>Your XAMPP-like environment is running with phpMyAdmin available!</p>
            </div>
            
            <?php if ($codespace_name): ?>
            <div class="info-box">
                <h3>🚀 GitHub Codespaces Detected</h3>
                <p>Access phpMyAdmin using the button below or through the forwarded port.</p>
                <a href="<?= $phpmyadmin_url ?>" target="_blank" class="button button-success">
                    🔗 Open phpMyAdmin (Port 8080)
                </a>
            </div>
            <?php endif; ?>
            
            <div class="grid">
                <div>
                    <h4>🔑 Database Credentials</h4>
                    <div class="code">
<strong>Primary Account:</strong>
Server: mysql
Username: root
Password: root
Database: test_db

<strong>Alternative Account:</strong>
Username: xampp
Password: xampp
                    </div>
                </div>
                
                <div>
                    <h4>🛠️ Quick Actions</h4>
                    <a href="/" class="button">🏠 Back to Home</a>
                    <a href="/db-test.php" class="button">🔍 Test DB Connection</a>
                    <a href="/sample-crud.php" class="button">📝 CRUD Demo</a>
                    <?php if ($codespace_name): ?>
                    <a href="<?= $phpmyadmin_url ?>" target="_blank" class="button button-success">
                        🗃️ phpMyAdmin
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="info-box">
                <h4>📋 Connection Instructions</h4>
                <ol>
                    <li>Click the phpMyAdmin button above to access the database interface</li>
                    <li>Use <strong>root/root</strong> or <strong>xampp/xampp</strong> credentials</li>
                    <li>The server field should show "mysql" (leave as default)</li>
                    <li>You can manage the <strong>test_db</strong> database or create new ones</li>
                </ol>
            </div>
            
            <div class="info-box">
                <h4>🎓 For Students & Educators</h4>
                <p>This phpMyAdmin setup provides:</p>
                <ul>
                    <li>Full database management capabilities</li>
                    <li>Import/Export functionality</li>
                    <li>SQL query interface</li>
                    <li>Visual table designer</li>
                    <li>User and privilege management</li>
                    <li>Database structure visualization</li>
                </ul>
            </div>
            
            <?php if (!$codespace_name): ?>
            <div class="info-box">
                <h4>💻 Local Development</h4>
                <p>If you're running this locally, phpMyAdmin should be available at:</p>
                <a href="http://localhost:8080" target="_blank" class="button">
                    🔗 localhost:8080
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
