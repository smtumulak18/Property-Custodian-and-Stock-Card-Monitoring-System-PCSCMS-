<?php
require_once 'includes/auth.php';require_roles(['admin','inventory_staff']);require_once 'config/db.php';
$id=(int)($_GET['id']??0);$s=$pdo->prepare("SELECT * FROM employees WHERE id=?");$s->execute([$id]);$e=$s->fetch();
if(!$e){http_response_code(404);exit('Employee not found.');}
$page_title='Employee Details | PCSCMS';include 'includes/header.php';include 'includes/sidebar.php';
?>
<main class="main-content">
<div class="topbar glass-card"><div class="topbar-left"><button class="btn btn-icon d-lg-none" id="sidebarOpenBtn"><i class="bi bi-list"></i></button><div><div class="eyebrow-text">EMPLOYEE PROFILE</div><h2 class="page-title mb-1"><?=htmlspecialchars($e['first_name'].' '.$e['last_name'])?></h2><p class="page-subtitle mb-0"><?=htmlspecialchars($e['employee_no'])?></p></div></div><div class="topbar-right"><a href="employee_edit.php?id=<?=$id?>" class="btn btn-gradient"><i class="bi bi-pencil me-2"></i>Edit</a><button class="btn btn-theme-toggle" id="themeToggle"><i class="bi bi-moon-stars-fill"></i><span>Dark</span></button></div></div>
<div class="detail-card glass-card mt-4"><div class="row g-4">
<?php foreach([['Employee Number',$e['employee_no']],['First Name',$e['first_name']],['Middle Name',$e['middle_name']?:'—'],['Last Name',$e['last_name']],['Department',$e['department']?:'—'],['Position',$e['position']?:'—'],['Contact Number',$e['contact_number']?:'—'],['Email',$e['email']?:'—'],['Status',ucfirst($e['status'])]] as $d): ?><div class="col-md-4"><div class="detail-label"><?=$d[0]?></div><div class="detail-value"><?=htmlspecialchars($d[1])?></div></div><?php endforeach; ?>
</div></div>
<div class="detail-card glass-card mt-4"><div class="section-kicker">PROPERTY CONNECTION</div><h4 class="section-title">Assigned property and MR records</h4><p class="text-muted mt-2 mb-0">This area will show this employee's assigned gadgets, Memorandum Receipts, and related records once the Assets and MR modules are built.</p></div>
</main>
<?php include 'includes/footer.php'; ?>