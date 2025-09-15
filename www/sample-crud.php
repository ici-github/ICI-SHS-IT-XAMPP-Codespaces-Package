<?php
/**
 * Simple CRUD Demo for XAMPP-like Environment
 * Demonstrates basic database operations
 */

// Database connection
try {
    $pdo = new PDO("mysql:host=mysql;dbname=test_db", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submissions
if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $stmt = $pdo->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
                $stmt->execute([$_POST['username'], $_POST['email']]);
                $message = "✅ User created successfully!";
                break;
                
            case 'update':
                $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
                $stmt->execute([$_POST['username'], $_POST['email'], $_POST['id']]);
                $message = "✅ User updated successfully!";
                break;
                
            case 'delete':
                $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                $message = "✅ User deleted successfully!";
                break;
        }
    }
}

// Get all users
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get user for editing
$editUser = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editUser = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Demo - XAMPP Environment</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1000px; margin: 0 auto; padding: 20px; }
        .header { background: #2196F3; color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .card { background: white; border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin: 20px 0; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; margin: 2px; }
        .btn-primary { background: #2196F3; color: white; }
        .btn-success { background: #4CAF50; color: white; }
        .btn-danger { background: #f44336; color: white; }
        .btn-warning { background: #ff9800; color: white; }
        .btn:hover { opacity: 0.9; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        .message { padding: 10px; margin: 10px 0; border-radius: 4px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .back-link { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>📝 CRUD Operations Demo</h1>
        <p>Create, Read, Update, Delete operations with MySQL database</p>
    </div>

    <div class="back-link">
        <a href="/" class="btn btn-primary">← Back to Home</a>
        <a href="/phpmyadmin/" class="btn btn-warning">🗃️ phpMyAdmin</a>
    </div>

    <?php if (isset($message)): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="card">
        <h3><?= $editUser ? '✏️ Edit User' : '➕ Add New User' ?></h3>
        <form method="POST">
            <input type="hidden" name="action" value="<?= $editUser ? 'update' : 'create' ?>">
            <?php if ($editUser): ?>
                <input type="hidden" name="id" value="<?= $editUser['id'] ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required 
                       value="<?= $editUser ? htmlspecialchars($editUser['username']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required 
                       value="<?= $editUser ? htmlspecialchars($editUser['email']) : '' ?>">
            </div>
            
            <button type="submit" class="btn btn-success">
                <?= $editUser ? '💾 Update User' : '➕ Create User' ?>
            </button>
            
            <?php if ($editUser): ?>
                <a href="?" class="btn btn-primary">Cancel</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="card">
        <h3>👥 Users List</h3>
        <?php if (empty($users)): ?>
            <p>No users found. Create the first user above!</p>
        <?php else: ?>
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
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= $user['created_at'] ?></td>
                            <td>
                                <a href="?edit=<?= $user['id'] ?>" class="btn btn-warning">✏️ Edit</a>
                                <form method="POST" style="display: inline;" 
                                      onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="btn btn-danger">🗑️ Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="card">
        <h3>💻 Code Example</h3>
        <p>This page demonstrates basic CRUD operations. Here's the PHP code structure:</p>
        <pre style="background: #f5f5f5; padding: 15px; border-radius: 4px; overflow-x: auto;"><code><?= htmlspecialchars('// Database connection
$pdo = new PDO("mysql:host=mysql;dbname=test_db", "root", "root");

// Create
$stmt = $pdo->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
$stmt->execute([$username, $email]);

// Read
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Update
$stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
$stmt->execute([$username, $email, $id]);

// Delete
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$id]);') ?></code></pre>
    </div>

    <footer style="margin-top: 50px; padding: 20px; text-align: center; color: #666;">
        <hr>
        <p>CRUD Demo • XAMPP-like Environment • Generated on <?= date('Y-m-d H:i:s') ?></p>
    </footer>
</body>
</html>
