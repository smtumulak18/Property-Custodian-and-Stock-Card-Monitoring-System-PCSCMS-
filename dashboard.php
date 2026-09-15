<?php
require_once 'includes/auth.php';
require_login();
require_once 'config/db.php';

$page_title = 'Dashboard | PCSCMS';
include 'includes/header.php';
include 'includes/sidebar.php';

$totalEmployees = (int)$pdo->query("SELECT COUNT(*) FROM employees")->fetchColumn();
$totalAssets = (int)$pdo->query("SELECT COUNT(*) FROM assets")->fetchColumn();
$totalStockCards = (int)$pdo->query("SELECT COUNT(*) FROM stock_cards")->fetchColumn();
$totalMR = (int)$pdo->query("SELECT COUNT(*) FROM mr_records")->fetchColumn();
$expiredMR = (int)$pdo->query("SELECT COUNT(*) FROM mr_records WHERE expiry_date < CURDATE()")->fetchColumn();

$availableAssets = (int)$pdo->query("SELECT COUNT(*) FROM assets WHERE status='available'")->fetchColumn();
$assignedAssets = (int)$pdo->query("SELECT COUNT(*) FROM assets WHERE status='assigned'")->fetchColumn();
$damagedAssets = (int)$pdo->query("SELECT COUNT(*) FROM assets WHERE status='damaged'")->fetchColumn();
$lostAssets = (int)$pdo->query("SELECT COUNT(*) FROM assets WHERE status='lost'")->fetchColumn();

$recentEmployees = $pdo->query("SELECT employee_no,first_name,last_name,department,position,status FROM employees ORDER BY id DESC LIMIT 5")->fetchAll();
$roleLabel = is_admin() ? 'Administrator' : 'Inventory Staff';
$full_name = $_SESSION['full_name'];
?>
<main class="main-content">
    <div class="topbar glass-card">
        <div class="topbar-left">
            <button class="btn btn-icon d-lg-none" id="sidebarOpenBtn"><i class="bi bi-list"></i></button>
            <div>
                <div class="eyebrow-text">PROPERTY CUSTODIAN AND STOCK CARD MONITORING SYSTEM</div>
                <h2 class="page-title mb-1">Welcome back, <?=htmlspecialchars($full_name)?></h2>
                <p class="page-subtitle mb-0">Monitor company property, employee records, MR activity, and stock information.</p>
            </div>
        </div>
        <div class="topbar-right">
            <div class="live-clock glass-card-soft"><div class="clock-label">LIVE TIME</div><div id="liveDateTime" class="clock-value">Loading...</div></div>
            <button class="btn btn-theme-toggle" id="themeToggle"><i class="bi bi-moon-stars-fill"></i><span>Dark</span></button>
        </div>
    </div>

    <section class="hero-panel glass-card mt-4">
        <div>
            <div class="hero-badge"><i class="bi bi-shield-check"></i><?=htmlspecialchars($roleLabel)?> Access</div>
            <h3 class="hero-title">Property monitoring, employee records, and inventory visibility in one place.</h3>
            <p class="hero-text">This is the central workspace for the company's property custodian and inventory process. Modules are being built progressively.</p>
            <div class="hero-actions">
                <a href="employees.php" class="btn btn-gradient"><i class="bi bi-people me-2"></i>Manage Employees</a>
                <?php if(is_admin()): ?><a href="accounts.php" class="btn btn-glass"><i class="bi bi-person-gear me-2"></i>User Accounts</a><?php endif; ?>
            </div>
        </div>
        <div class="hero-stats">
            <div class="mini-stat glass-card-soft"><div class="mini-stat-label">Current Role</div><div class="mini-stat-value"><?=htmlspecialchars($roleLabel)?></div></div>
            <div class="mini-stat glass-card-soft"><div class="mini-stat-label">Working Module</div><div class="mini-stat-value">Employee Management</div></div>
            <div class="mini-stat glass-card-soft"><div class="mini-stat-label">Next Build</div><div class="mini-stat-value">Assets / Property</div></div>
        </div>
    </section>

    <section class="stats-grid mt-4">
        <?php
        $stats = [
            ['Total Employees',$totalEmployees,'bi-people-fill'],
            ['Assets / Property',$totalAssets,'bi-pc-display-horizontal'],
            ['Stock Cards',$totalStockCards,'bi-card-checklist'],
            ['MR Records',$totalMR,'bi-file-earmark-text-fill'],
            ['Expired MR',$expiredMR,'bi-exclamation-triangle-fill'],
        ];
        foreach($stats as $s): ?>
            <div class="stat-card glass-card"><div class="stat-card-top"><span class="stat-label"><?=$s[0]?></span><div class="stat-icon"><i class="bi <?=$s[2]?>"></i></div></div><div class="stat-value"><?=$s[1]?></div><div class="stat-meta">Current records in the database</div></div>
        <?php endforeach; ?>
    </section>

    <section class="dashboard-layout mt-4">
        <div>
            <div class="section-card glass-card">
                <div class="section-header"><div><div class="section-kicker">EMPLOYEE RECORDS</div><h4 class="section-title">Recently added employees</h4></div><a href="employee_create.php" class="btn btn-gradient btn-sm"><i class="bi bi-plus-lg me-1"></i>Add</a></div>
                <div class="table-responsive mt-3">
                    <table class="table custom-table align-middle mb-0"><thead><tr><th>Employee No.</th><th>Name</th><th>Department</th><th>Position</th><th>Status</th></tr></thead><tbody>
                    <?php foreach($recentEmployees as $emp): ?><tr><td><?=htmlspecialchars($emp['employee_no'])?></td><td><?=htmlspecialchars($emp['first_name'].' '.$emp['last_name'])?></td><td><?=htmlspecialchars($emp['department'] ?: '—')?></td><td><?=htmlspecialchars($emp['position'] ?: '—')?></td><td><span class="status-pill <?=$emp['status']==='active'?'active':'inactive'?>"><?=ucfirst($emp['status'])?></span></td></tr>
                    <?php endforeach; ?>
                    <?php if(!$recentEmployees): ?><tr><td colspan="5" class="text-center py-4 text-muted">No employees yet.</td></tr><?php endif; ?>
                    </tbody></table>
                </div>
            </div>
            <div class="section-card glass-card mt-4">
                <div class="section-header"><div><div class="section-kicker">ASSET STATUS</div><h4 class="section-title">Current property snapshot</h4></div></div>
                <div class="asset-status-grid">
                    <?php foreach([['Available',$availableAssets],['Assigned',$assignedAssets],['Damaged',$damagedAssets],['Lost',$lostAssets]] as $a): ?><div class="asset-status-item glass-card-soft"><div class="asset-status-icon"><i class="bi bi-box-seam"></i></div><div><div class="asset-status-label"><?=$a[0]?></div><div class="asset-status-value"><?=$a[1]?></div></div></div><?php endforeach; ?>
                </div>
            </div>
        </div>
        <div>
            <div class="section-card glass-card">
                <div class="section-kicker">QUICK ACTIONS</div><h4 class="section-title">Workflow shortcuts</h4>
                <div class="quick-actions-grid">
                    <a href="employee_create.php" class="quick-action-btn"><div class="quick-action-icon"><i class="bi bi-person-plus-fill"></i></div><div><strong>Add Employee</strong><div class="text-muted small">Create a personnel record</div></div></a>
                    <?php if(is_admin()): ?><a href="accounts.php" class="quick-action-btn"><div class="quick-action-icon"><i class="bi bi-person-gear"></i></div><div><strong>Manage Accounts</strong><div class="text-muted small">Admin-only account control</div></div></a><?php endif; ?>
                    <button class="quick-action-btn" disabled><div class="quick-action-icon"><i class="bi bi-pc-display"></i></div><div><strong>Register Asset</strong><div class="text-muted small">Available in the next batch</div></div></button>
                    <button class="quick-action-btn" disabled><div class="quick-action-icon"><i class="bi bi-file-earmark-plus"></i></div><div><strong>Create MR</strong><div class="text-muted small">Available in a later batch</div></div></button>
                </div>
            </div>
            <div class="section-card glass-card mt-4"><div class="section-kicker">SYSTEM ROADMAP</div><h4 class="section-title">Build progress</h4><div class="roadmap-list">
                <div class="roadmap-item"><div class="roadmap-icon"><i class="bi bi-check2-circle"></i></div><div><div class="roadmap-title">Login + Logout</div><div class="roadmap-text">Two-role authentication is active.</div></div></div>
                <div class="roadmap-item"><div class="roadmap-icon"><i class="bi bi-check2-circle"></i></div><div><div class="roadmap-title">Dashboard UI</div><div class="roadmap-text">Responsive glass/tinted layout.</div></div></div>
                <div class="roadmap-item"><div class="roadmap-icon"><i class="bi bi-check2-circle"></i></div><div><div class="roadmap-title">Employee Management</div><div class="roadmap-text">CRUD, search, view, and status.</div></div></div>
                <div class="roadmap-item"><div class="roadmap-icon"><i class="bi bi-circle"></i></div><div><div class="roadmap-title">Assets / Property</div><div class="roadmap-text">Next module.</div></div></div>
                <div class="roadmap-item"><div class="roadmap-icon"><i class="bi bi-circle"></i></div><div><div class="roadmap-title">MR + Stock Cards + Reports</div><div class="roadmap-text">Later modules.</div></div></div>
            </div></div>
        </div>
    </section>
</main>
<?php include 'includes/footer.php'; ?>