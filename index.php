<?php
require_once 'config/db.php';
require_once 'includes/auth.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT id, username, password, full_name, role, status FROM users WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && $user['status'] === 'active' && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Invalid username or password.';
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | PCSCMS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/property-custodian-system/assets/css/style.css">
</head>
<body>
<div class="animated-bg"></div><div class="bg-grid"></div><div class="cursor-glow" id="cursorGlow"></div>
<div class="login-page">
    <div class="login-card glass-card">
        <div class="login-logo"><i class="bi bi-box-seam-fill"></i></div>
        <h1 class="login-title">PCSCMS</h1>
        <p class="login-subtitle">Property Custodian and Stock Card Monitoring System</p>

        <?php if ($error): ?>
            <div class="alert alert-danger mt-4"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" class="mt-4">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control custom-input mb-3" required autofocus>

            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control custom-input mb-3" required>

            <button class="btn btn-gradient w-100 py-3" type="submit">
                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
            </button>
        </form>

        <div class="demo-box">
            <strong>Initial demo accounts</strong><br>
            Admin: <code>admin</code> / <code>admin123</code><br>
            Inventory Staff: <code>inventory</code> / <code>inventory123</code>
        </div>
    </div>
</div>
<script src="/property-custodian-system/assets/js/app.js"></script>
</body>
</html>
