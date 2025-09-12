<?php
// Sample PHP Application - Database CRUD Operations
// This demonstrates a simple web application using PHP and MySQL

// Database configuration
$host = 'mysql';
$username = 'root';
$password = 'xampp';
$database = 'xampp';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submissions
$message = '';
if ($_POST) {
    if (isset($_POST['add_user'])) {
        $stmt = $pdo->prepare("INSERT INTO sample_users (username, email) VALUES (?, ?)");
        try {
            $stmt->execute([$_POST['username'], $_POST['email']]);
            $message = '<div class="alert success">User added successfully!</div>';
        } catch (PDOException $e) {
            $message = '<div class="alert error">Error: ' . $e->getMessage() . '</div>';
        }
    }
    
    if (isset($_POST['delete_user'])) {
        $stmt = $pdo->prepare("DELETE FROM sample_users WHERE id = ?");
        $stmt->execute([$_POST['user_id']]);
        $message = '<div class="alert success">User deleted successfully!</div>';
    }
}

// Fetch all users
$stmt = $pdo->query("SELECT * FROM sample_users ORDER BY created_at DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sample PHP Application - User Management</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #f5f7fa;
            padding: 20px;
        }
        .container { 
            max-width: 1000px; 
            margin: 0 auto; 
            background: white; 
            border-radius: 10px; 
            padding: 30px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        h1 { 
            color: #333; 
            margin-bottom: 30px; 
            text-align: center;
            font-size: 2.2em;
        }
        .form-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #555;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e8ed;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus, input[type="email"]:focus {
            outline: none;
            border-color: #667eea;
        }
        button {
            background: #667eea;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }
        button:hover { background: #5a67d8; }
        .delete-btn {
            background: #e53e3e;
            padding: 6px 12px;
            font-size: 14px;
        }
        .delete-btn:hover { background: #c53030; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
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
        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .alert.success {
            background: #c6f6d5;
            color: #22543d;
            border: 1px solid #9ae6b4;
        }
        .alert.error {
            background: #fed7d7;
            color: #742a2a;
            border: 1px solid #feb2b2;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 5px;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="welcome.html">← Back to Welcome</a> |
            <a href="index.php">PHP Info</a> |
            <a href="test-db.php">Database Test</a>
        </div>
        
        <h1>👥 User Management System</h1>
        
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?= count($users) ?></div>
                <div>Total Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= date('Y') ?></div>
                <div>Current Year</div>
            </div>
        </div>
        
        <?= $message ?>
        
        <div class="form-section">
            <h2>Add New User</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <button type="submit" name="add_user">Add User</button>
            </form>
        </div>
        
        <h2>Current Users</h2>
        <?php if (count($users) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['created_at']) ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" name="delete_user" class="delete-btn" 
                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No users found. Add some users using the form above!</p>
        <?php endif; ?>
        
        <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
            <h3>🎓 Learning Notes:</h3>
            <ul>
                <li>This app demonstrates PHP PDO for database operations</li>
                <li>Uses prepared statements for security</li>
                <li>Includes basic CRUD (Create, Read, Delete) operations</li>
                <li>Shows how to handle form submissions in PHP</li>
                <li>Demonstrates error handling with try-catch blocks</li>
            </ul>
        </div>
    </div>
</body>
</html>
