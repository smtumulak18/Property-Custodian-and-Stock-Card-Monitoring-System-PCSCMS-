<?php
require_once 'includes/auth.php';
require_roles(['admin','inventory_staff']);
require_once 'config/db.php';

$id=(int)($_GET['id']??0);
$stmt=$pdo->prepare("SELECT * FROM employees WHERE id=?");$stmt->execute([$id]);$employee=$stmt->fetch();
if(!$employee){http_response_code(404);exit('Employee not found.');}
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $data=[trim($_POST['employee_no']??''),trim($_POST['first_name']??''),trim($_POST['middle_name']??''),trim($_POST['last_name']??''),trim($_POST['department']??''),trim($_POST['position']??''),trim($_POST['contact_number']??''),trim($_POST['email']??''),$_POST['status']??'active',$id];
    if($data[0]===''||$data[1]===''||$data[3]==='') $error='Employee number, first name, and last name are required.';
    else{try{$s=$pdo->prepare("UPDATE employees SET employee_no=?,first_name=?,middle_name=?,last_name=?,department=?,position=?,contact_number=?,email=?,status=? WHERE id=?");$s->execute($data);header("Location: employee_view.php?id=$id&updated=1");exit;}catch(PDOException $e){$error='Unable to update. Employee number may already exist.';}}
}
$page_title='Edit Employee | PCSCMS';include 'includes/header.php';include 'includes/sidebar.php';
?>
<main class="main-content">
<div class="topbar glass-card"><div class="topbar-left"><button class="btn btn-icon d-lg-none" id="sidebarOpenBtn"><i class="bi bi-list"></i></button><div><div class="eyebrow-text">EMPLOYEE MANAGEMENT</div><h2 class="page-title mb-1">Edit Employee</h2><p class="page-subtitle mb-0">Update personnel information.</p></div></div><button class="btn btn-theme-toggle" id="themeToggle"><i class="bi bi-moon-stars-fill"></i><span>Dark</span></button></div>
<div class="form-card glass-card mt-4"><form method="POST"><div class="row g-3">
<?php
$fields=[['employee_no','Employee Number','col-md-4'],['first_name','First Name','col-md-4'],['middle_name','Middle Name','col-md-4'],['last_name','Last Name','col-md-4'],['department','Department','col-md-4'],['position','Position','col-md-4'],['contact_number','Contact Number','col-md-6'],['email','Email','col-md-6']];
foreach($fields as [$name,$label,$col]): ?><div class="<?=$col?>"><label class="form-label"><?=$label?></label><input name="<?=$name?>" class="form-control custom-input" value="<?=htmlspecialchars($_POST[$name]??$employee[$name]??'')?>"></div><?php endforeach; ?>
<div class="col-md-4"><label class="form-label">Status</label><select name="status" class="form-select custom-select"><option value="active" <?=($_POST['status']??$employee['status'])==='active'?'selected':''?>>Active</option><option value="inactive" <?=($_POST['status']??$employee['status'])==='inactive'?'selected':''?>>Inactive</option></select></div>
</div>
<?php if($error): ?><div class="alert alert-danger alert-glass mt-3"><?=htmlspecialchars($error)?></div><?php endif; ?>
<div class="d-flex gap-2 justify-content-end mt-4"><a href="employee_view.php?id=<?=$id?>" class="btn btn-glass">Cancel</a><button class="btn btn-gradient"><i class="bi bi-save me-2"></i>Save Changes</button></div>
</form></div></main>
<?php include 'includes/footer.php'; ?>