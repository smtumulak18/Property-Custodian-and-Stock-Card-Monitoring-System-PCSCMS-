<?php
$current_page = basename($_SERVER['PHP_SELF']);
$role = $_SESSION['role'] ?? '';
$full_name = $_SESSION['full_name'] ?? 'User';
$role_label = $role === 'admin' ? 'Administrator' : 'Inventory Staff';
?>
<aside class="sidebar glass-card" id="sidebar">
    <div class="sidebar-top">
        <div class="brand-wrap">
            <div class="brand-icon"><i class="bi bi-box-seam-fill"></i></div>
            <div>
                <div class="brand-title">PCSCMS</div>
                <small class="brand-subtitle">Inventory Monitoring</small>
            </div>
        </div>
        <button class="btn btn-icon d-lg-none" id="sidebarCloseBtn" type="button">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="sidebar-user glass-card-soft mt-4">
        <div class="user-avatar"><?= strtoupper(substr($full_name, 0, 1)) ?></div>
        <div class="user-meta">
            <h6><?= htmlspecialchars($full_name) ?></h6>
            <span class="role-badge role-<?= htmlspecialchars($role) ?>">
                <?= htmlspecialchars($role_label) ?>
            </span>
        </div>
    </div>

    <div class="sidebar-section-label mt-4">MAIN MENU</div>
    <nav class="sidebar-nav mt-2">
        <a href="dashboard.php" class="nav-link-custom <?= $current_page === 'dashboard.php' ? 'active' : '' ?>">
            <span class="nav-icon"><i class="bi bi-grid-1x2-fill"></i></span>Dashboard
        </a>

        <a href="employees.php" class="nav-link-custom <?= in_array($current_page, ['employees.php','employee_create.php','employee_edit.php','employee_view.php']) ? 'active' : '' ?>">
            <span class="nav-icon"><i class="bi bi-people-fill"></i></span>Employees
        </a>

        <a href="#" class="nav-link-custom disabled-link" onclick="return false;">
            <span class="nav-icon"><i class="bi bi-pc-display-horizontal"></i></span>Assets / Property
            <small class="coming-soon">Next</small>
        </a>

        <a href="#" class="nav-link-custom disabled-link" onclick="return false;">
            <span class="nav-icon"><i class="bi bi-file-earmark-text-fill"></i></span>MR Records
            <small class="coming-soon">Next</small>
        </a>

        <a href="#" class="nav-link-custom disabled-link" onclick="return false;">
            <span class="nav-icon"><i class="bi bi-card-checklist"></i></span>Stock Cards
            <small class="coming-soon">Next</small>
        </a>

        <a href="#" class="nav-link-custom disabled-link" onclick="return false;">
            <span class="nav-icon"><i class="bi bi-bar-chart-fill"></i></span>Reports
            <small class="coming-soon">Later</small>
        </a>
    </nav>

    <?php if ($role === 'admin'): ?>
        <div class="sidebar-section-label mt-4">ADMINISTRATION</div>
        <nav class="sidebar-nav mt-2">
            <a href="accounts.php" class="nav-link-custom <?= $current_page === 'accounts.php' ? 'active' : '' ?>">
                <span class="nav-icon"><i class="bi bi-person-gear"></i></span>User Accounts
            </a>
        </nav>
    <?php endif; ?>

    <div class="sidebar-footer glass-card-soft mt-4">
        <div class="small text-muted mb-2">System Status</div>
        <div class="status-chip"><span class="status-dot"></span>Online</div>
        <a href="logout.php" class="btn btn-danger-soft w-100 mt-3">
            <i class="bi bi-box-arrow-right me-2"></i>Logout
        </a>
    </div>
</aside>
