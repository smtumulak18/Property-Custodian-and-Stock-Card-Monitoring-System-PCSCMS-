<?php
require_once 'includes/auth.php';require_roles(['admin']);require_once 'config/db.php';
$id=(int)($_GET['id']??0);$s=$pdo->prepare("SELECT * FROM users WHERE id=? AND role='inventory_staff'");$s->execute([$id]);$u=$s->fetch();if(!$u)exit('Account not found.');
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=trim($_POST['full_name']??'');$password=$_POST['password']??'';
    if($name==='')$error='Full name is required.';
    else{if($password!==''){$s=$pdo->prepare("UPDATE users SET full_name=?,password=? WHERE id=? AND role='inventory_staff'");$s->execute([$name,password_hash($password,PASSWORD_DEFAULT),$id]);}else{$s=$pdo->prepare("UPDATE users SET full_name=? WHERE id=? AND role='inventory_staff'");$s->execute([$name,$id]);}header('Location: accounts.php?updated=1');exit;}
}
$page_title='Edit Account | PCSCMS';include 'includes/header.php';include 'includes/sidebar.php';
?>
<main class="main-content"><div class="topbar glass-card"><div class="topbar-left"><button class="btn btn-icon d-lg-none" id="sidebarOpenBtn"><i class="bi bi-list"></i></button><div><div class="eyebrow-text">ADMINISTRATION</div><h2 class="page-title mb-1">Edit Inventory Staff</h2><p class="page-subtitle mb-0">Update the staff name or reset the password.</p></div></div><button class="btn btn-theme-toggle" id="themeToggle"><i class="bi bi-moon-stars-fill"></i><span>Dark</span></button></div>
<div class="form-card glass-card mt-4"><?php if($error): ?><div class="alert alert-danger alert-glass"><?=htmlspecialchars($error)?></div><?php endif; ?><form method="POST"><div class="row g-3"><div class="col-md-6"><label class="form-label">Full Name</label><input name="full_name" class="form-control custom-input" value="<?=htmlspecialchars($u['full_name'])?>" required></div><div class="col-md-6"><label class="form-label">Username</label><input class="form-control custom-input" value="<?=htmlspecialchars($u['username'])?>" disabled></div><div class="col-md-6"><label class="form-label">New Password</label><input type="password" name="password" class="form-control custom-input"><small class="text-muted">Leave blank to keep the current password.</small></div></div><div class="d-flex justify-content-end gap-2 mt-4"><a href="accounts.php" class="btn btn-glass">Cancel</a><button class="btn btn-gradient">Save Changes</button></div></form></div></main>
<?php include 'includes/footer.php'; ?>