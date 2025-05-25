<?php
session_start();
require_once 'db.php';

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = $isLoggedIn && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

if (!$isAdmin) {
    header('Location: project.php');
    exit();
}

include 'banner.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $userId = $_POST['user_id'] ?? null;
        
        try {
            switch ($_POST['action']) {
                case 'delete':
                    $stmt = $db->prepare("DELETE FROM Users WHERE user_id = ?");
                    $stmt->execute([$userId]);
                    $message = "User deleted successfully.";
                    break;
                    
                case 'edit':
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $role = $_POST['role'];
                    
                    $stmt = $db->prepare("UPDATE Users SET username = ?, email = ?, role = ? WHERE user_id = ?");
                    $stmt->execute([$username, $email, $role, $userId]);
                    $message = "User updated successfully.";
                    break;
                    
                case 'add':
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $role = $_POST['role'];
                    
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    
                    $stmt = $db->prepare("INSERT INTO Users (username, email, password_hash, role) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$username, $email, $passwordHash, $role]);
                    $message = "User added successfully.";
                    break;
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}

$users = [];
try {
    $stmt = $db->query("SELECT user_id, username, email, role, created_at FROM Users ORDER BY created_at DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Failed to fetch users: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | AUTOSPHERE</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        
        .admin-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #8de020;
            color: white;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        
        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }
        
        .btn-edit {
            background-color: #17a2b8;
        }
        
        .btn-delete {
            background-color: #dc3545;
        }
        
        .btn-add {
            background-color: #28a745;
            margin-bottom: 20px;
        }
        
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .form-actions {
            text-align: right;
        }
        
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Admin Panel - User Management</h1>
        
        <?php if (isset($message)): ?>
            <div class="message success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <button id="show-add-form" class="btn btn-add">Add New User</button>
        
        <div id="add-user-form" class="form-container hidden">
            <h2>Add New User</h2>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                
                <div class="form-group">
                    <label for="add-username">Username</label>
                    <input type="text" id="add-username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="add-email">Email</label>
                    <input type="email" id="add-email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="add-password">Password</label>
                    <input type="password" id="add-password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="add-role">Role</label>
                    <select id="add-role" name="role">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="button" id="cancel-add" class="btn btn-delete">Cancel</button>
                    <button type="submit" class="btn btn-add">Add User</button>
                </div>
            </form>
        </div>
        
        <div id="edit-user-form" class="form-container hidden">
            <h2>Edit User</h2>
            <form method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" id="edit-user-id" name="user_id">
                
                <div class="form-group">
                    <label for="edit-username">Username</label>
                    <input type="text" id="edit-username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="edit-email">Email</label>
                    <input type="email" id="edit-email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="edit-role">Role</label>
                    <select id="edit-role" name="role">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="button" id="cancel-edit" class="btn btn-delete">Cancel</button>
                    <button type="submit" class="btn btn-edit">Update User</button>
                </div>
            </form>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                        <td class="action-buttons">
                            <button class="btn btn-edit edit-user" 
                                    data-id="<?php echo $user['user_id']; ?>"
                                    data-username="<?php echo htmlspecialchars($user['username']); ?>"
                                    data-email="<?php echo htmlspecialchars($user['email']); ?>"
                                    data-role="<?php echo htmlspecialchars($user['role']); ?>">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this user?');">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <script>
        document.getElementById('show-add-form').addEventListener('click', function() {
            document.getElementById('add-user-form').classList.remove('hidden');
            document.getElementById('edit-user-form').classList.add('hidden');
        });
        
        document.getElementById('cancel-add').addEventListener('click', function() {
            document.getElementById('add-user-form').classList.add('hidden');
        });
        
        document.querySelectorAll('.edit-user').forEach(button => {
            button.addEventListener('click', function() {
                const form = document.getElementById('edit-user-form');
                form.classList.remove('hidden');
                document.getElementById('add-user-form').classList.add('hidden');
                
                document.getElementById('edit-user-id').value = this.dataset.id;
                document.getElementById('edit-username').value = this.dataset.username;
                document.getElementById('edit-email').value = this.dataset.email;
                document.getElementById('edit-role').value = this.dataset.role;
            });
        });
        
        document.getElementById('cancel-edit').addEventListener('click', function() {
            document.getElementById('edit-user-form').classList.add('hidden');
        });
    </script>
</body>
</html>