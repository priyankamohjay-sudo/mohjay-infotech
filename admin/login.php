<?php
require_once dirname(__DIR__) . '/includes/config.php';
session_start();

// Static Credentials (Change these for security!)
$admin_user = 'admin';
$admin_pass = 'password123'; 

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: blogs/index.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Mohjay Infotech</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { width: 100%; max-width: 400px; padding: 2rem; border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .btn-primary { background-color: #0d6efd; border: none; padding: 0.6rem; border-radius: 8px; font-weight: 600; }
        .form-control { padding: 0.7rem; border-radius: 8px; }
        .logo { width: 150px; display: block; margin: 0 auto 1.5rem; }
    </style>
</head>
<body>
    <div class="card login-card">
        <img src="<?= BASE_URL ?>assets/imgs/logo/mohjaylogo-dark.png" alt="Logo" class="logo">
        <h4 class="text-center mb-4">Admin Login</h4>
        
        <?php if ($error): ?>
            <div class="alert alert-danger py-2"><?= $error ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>