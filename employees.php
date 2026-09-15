<?php
require_once 'includes/auth.php';
require_roles(['admin','inventory_staff']);
require_once 'config/db.php';

$page_title='Employees | PCSCMS';
include 'includes/header.php';
include 'includes/sidebar.php';

$q = trim($_GET['q'] ?? '');
if ($q !== '') {
    $stmt=$pdo->prepare("SELECT * FROM employees WHERE employee_no LIKE ? OR first_name LIKE ? OR last_name LIKE ? OR department LIKE ? OR position LIKE ? ORDER BY id DESC");
    $like="%$q%"; $stmt->execute([$like,$like,$like,$like,$like]);
    $employees=$stmt->fetchAll();
} else {
    $employees=$pdo->query("SELECT * FROM employees ORDER BY id DESC")->fetchAll();
}
?>
<main class="main-content">
    <div class="topbar glass-card">
        <div class="topbar-left"><button class="btn btn-icon d-lg-none" id="sidebarOpenBtn"><i class="bi bi-list"></i></button><div><div class="eyebrow-text">EMPLOYEE MANAGEMENT</div><h2 class="page-title mb-1">Employees</h2><p class="page-subtitle mb-0">Manage personnel records used for property and MR assignment.</p></div></div>
        <div class="topbar-right"><a href="employee_create.php" class="btn btn-gradient"><i class="bi bi-person-plus-fill me-2"></i>Add Employee</a><button class="btn btn-theme-toggle" id="themeToggle"><i class="bi bi-moon-stars-fill"></i><span>Dark</span></button></div>
    </div>

    <div class="toolbar glass-card mt-4">
        <form class="search-box w-100" method="GET"><div class="input-group"><input name="q" value="<?=htmlspecialchars($q)?>" class="form-control custom-input" placeholder="Search employee no., name, department, or position"><button class="btn btn-gradient"><i class="bi bi-search"></i></button></div></form>
        <div class="text-muted small text-nowrap"><?=count($employees)?> record(s)</div>
    </div>

    <div class="section-card glass-card mt-4">
        <div class="table-responsive">
            <table class="table custom-table align-middle mb-0">
                <thead><tr><th>Employee No.</th><th>Name</th><th>Department</th><th>Position</th><th>Contact</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                <?php foreach($employees as $e): ?>
                    <tr>
                        <td><strong><?=htmlspecialchars($e['employee_no'])?></strong></td>
                        <td><?=htmlspecialchars($e['first_name'].' '.($e['middle_name'] ? $e['middle_name'].' ' : '').$e['last_name'])?></td>
                        <td><?=htmlspecialchars($e['department'] ?: '—')?></td>
                        <td><?=htmlspecialchars($e['position'] ?: '—')?></td>
                        <td><?=htmlspecialchars($e['contact_number'] ?: '—')?></td>
                        <td><span class="status-pill <?=$e['status']==='active'?'active':'inactive'?>"><?=ucfirst($e['status'])?></span></td>
                        <td class="text-end text-nowrap">
                            <a class="btn btn-sm btn-glass" href="employee_view.php?id=<?=$e['id']?>"><i class="bi bi-eye"></i></a>
                            <a class="btn btn-sm btn-glass" href="employee_edit.php?id=<?=$e['id']?>"><i class="bi bi-pencil"></i></a>
                            <form class="d-inline" method="POST" action="employee_delete.php" onsubmit="return confirm('Delete this employee record?');"><input type="hidden" name="id" value="<?=$e['id']?>"><button class="btn btn-sm btn-danger-soft"><i class="bi bi-trash"></i></button></form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if(!$employees): ?><tr><td colspan="7" class="text-center py-5 text-muted">No employee records found.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>