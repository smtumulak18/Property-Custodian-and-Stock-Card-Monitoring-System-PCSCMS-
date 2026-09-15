<?php
require_once 'config/db.php';

$messages = [];
try {
    $count = (int)$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    if ($count === 0) {
        $stmt = $pdo->prepare("INSERT INTO users (username,password,full_name,role,status) VALUES (?,?,?,?,?)");
        $stmt->execute(['admin', password_hash('admin123', PASSWORD_DEFAULT), 'System Administrator', 'admin', 'active']);
        $stmt->execute(['inventory', password_hash('inventory123', PASSWORD_DEFAULT), 'Inventory Staff', 'inventory_staff', 'active']);
        $messages[] = 'Two initial accounts were created.';
    } else {
        $messages[] = 'Users already exist. No demo accounts were added.';
    }
} catch (Throwable $e) {
    $messages[] = 'Setup failed. Import database.sql first.';
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>PCSCMS Setup</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light"><div class="container py-5"><div class="card p-4">
<h2>PCSCMS Setup</h2>
<?php foreach($messages as $m): ?><div class="alert alert-info"><?=htmlspecialchars($m)?></div><?php endforeach; ?>
<p>For security, delete <strong>setup.php</strong> from the project after this succeeds.</p>
<a class="btn btn-primary" href="index.php">Go to Login</a>
</div></div></body></html>