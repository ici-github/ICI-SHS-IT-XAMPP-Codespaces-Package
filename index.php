<?php
// PHP Information Page
// This page displays comprehensive PHP configuration information

// Set the page title and styling
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Information - XAMPP-like Environment</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: #f5f7fa; 
        }
        .nav {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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
        .info-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="nav">
        <a href="welcome.html">← Back to Welcome</a> |
        <a href="sample-app.php">Sample App</a> |
        <a href="test-db.php">Database Test</a> |
        <a href="/phpmyadmin" target="_blank">phpMyAdmin</a>
    </div>
    <div class="info-container">';

// Display PHP information
phpinfo();

echo '
    </div>
</body>
</html>';
?>
