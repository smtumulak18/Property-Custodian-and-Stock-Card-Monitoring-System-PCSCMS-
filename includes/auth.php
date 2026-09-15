<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function require_login(): void {
    if (empty($_SESSION['user_id'])) {
        header('Location: index.php');
        exit;
    }
}

function require_roles(array $roles): void {
    require_login();

    if (!in_array($_SESSION['role'] ?? '', $roles, true)) {
        http_response_code(403);
        exit('Access denied.');
    }
}

function is_admin(): bool {
    return ($_SESSION['role'] ?? '') === 'admin';
}

function is_inventory_staff(): bool {
    return ($_SESSION['role'] ?? '') === 'inventory_staff';
}
?>