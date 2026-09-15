<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = $page_title ?? 'PCSCMS';
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/property-custodian-system/assets/css/style.css">
</head>
<body>
<div class="animated-bg"></div>
<div class="bg-grid"></div>
<div class="cursor-glow" id="cursorGlow"></div>

<?php if (!empty($_SESSION['user_id'])): ?>
    <div class="mobile-sidebar-backdrop" id="mobileSidebarBackdrop"></div>
    <div class="app-shell">
<?php endif; ?>
