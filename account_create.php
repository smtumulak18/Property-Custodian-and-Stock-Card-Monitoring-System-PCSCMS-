<?php
require_once 'includes/auth.php';require_roles(['admin']);require_once 'config/db.php';
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=trim($_POST['full_name']??'');$username=trim($_POST['username']??'');$password=$_POST['password']??'';$confirm=$_POST['confirm_password']??'';
    if($name===''||$username===''||$password==='')$error='All fields are required.';
    elseif($password!==$confirm)$error='Passwords do not match.';
    elseif(strlen($password)<8)$error='Password must be at least 8 characters.';
    else{try{$s=$pdo->prepare("INSERT INTO users(username,password,full_name,role,status) VALUES(?,?,?,?,?)");$s->execute([$username,password_hash($password,PASSWORD_DEFAULT),$name,'inventory_staff','active']);header('Location: accounts.php?created=1');exit;}catch(PDOException $e){$error='Username already exists.';}}
}
$page_title='Add Account | PCSCMS';include 'includes/header.php';include 'includes/sidebar.php';
?>
<main class="main-content"><div class="topbar glass-card"><div class="topbar-left"><button class="btn btn-icon d-lg-none" id="sidebarOpenBtn"><i class="bi bi-list"></i></button><div><div class="eyebrow-text">ADMINISTRATION</div><h2 class="page-title mb-1">Create Inventory Staff Account</h2><p class="page-subtitle mb-0">Only the Administrator can create this account type.</p></div></div><button class="btn btn-theme-toggle" id="themeToggle"><i class="bi bi-moon-stars-fill"></i><span>Dark</span></button></div>
<div class="form-card glass-card mt-4"><?php if($error): ?><div class="alert alert-danger alert-glass"><?=htmlspecialchars($error)?></div><?php endif; ?><form method="POST"><div class="row g-3">
<div class="col-md-6"><label class="form-label">Full Name *</label><input name="full_name" class="form-control custom-input" required></div>
<div class="col-md-6"><label class="form-label">Username *</label><input name="username" class="form-control custom-input" required></div>
<div class="col-md-6"><label class="form-label">Password *</label><input type="password" name="password" class="form-control custom-input" required></div>
<div class="col-md-6"><label class="form-label">Confirm Password *</label><input type="password" name="confirm_password" class="form-control custom-input" required></div>
<div class="col-12"><div class="alert alert-glass mb-0"><strong>Role:</strong> Inventory Staff. The role is fixed and cannot be changed here.</div></div>
</div><div class="d-flex justify-content-end gap-2 mt-4"><a href="accounts.php" class="btn btn-glass">Cancel</a><button class="btn btn-gradient">Create Account</button></div></form></div></main>
<?php include 'includes/footer.php'; ?>