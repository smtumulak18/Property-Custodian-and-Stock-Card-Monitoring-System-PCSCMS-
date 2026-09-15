<?php
require_once 'includes/auth.php';
require_roles(['admin','inventory_staff']);
require_once 'config/db.php';

$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $data=[
        trim($_POST['employee_no']??''),trim($_POST['first_name']??''),trim($_POST['middle_name']??''),
        trim($_POST['last_name']??''),trim($_POST['department']??''),trim($_POST['position']??''),
        trim($_POST['contact_number']??''),trim($_POST['email']??''),$_POST['status']??'active'
    ];
    if($data[0]===''||$data[1]===''||$data[3]==='') $error='Employee number, first name, and last name are required.';
    else{
        try{
            $stmt=$pdo->prepare("INSERT INTO employees (employee_no,first_name,middle_name,last_name,department,position,contact_number,email,status) VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt->execute($data); header('Location: employees.php?created=1'); exit;
        }catch(PDOException $e){$error = (($e->errorInfo[1] ?? 0) === 1062) ? 'Employee number already exists.' : 'Unable to save the employee.';}
    }
}
$page_title='Add Employee | PCSCMS'; include 'includes/header.php'; include 'includes/sidebar.php';
?>
<main class="main-content">
<div class="topbar glass-card"><div class="topbar-left"><button class="btn btn-icon d-lg-none" id="sidebarOpenBtn"><i class="bi bi-list"></i></button><div><div class="eyebrow-text">EMPLOYEE MANAGEMENT</div><h2 class="page-title mb-1">Add Employee</h2><p class="page-subtitle mb-0">Create a personnel record. No login account is created for employees.</p></div></div><div class="topbar-right"><button class="btn btn-theme-toggle" id="themeToggle"><i class="bi bi-moon-stars-fill"></i><span>Dark</span></button></div></div>
<div class="form-card glass-card mt-4">
<?php if($error): ?><div class="alert alert-danger alert-glass"><?=$error?></div><?php endif; ?>
<form method="POST">
<div class="row g-3">
<div class="col-md-4"><label class="form-label">Employee Number *</label><input name="employee_no" class="form-control custom-input" required value="<?=htmlspecialchars($_POST['employee_no']??'')?>"></div>
<div class="col-md-4"><label class="form-label">First Name *</label><input name="first_name" class="form-control custom-input" required value="<?=htmlspecialchars($_POST['first_name']??'')?>"></div>
<div class="col-md-4"><label class="form-label">Middle Name</label><input name="middle_name" class="form-control custom-input" value="<?=htmlspecialchars($_POST['middle_name']??'')?>"></div>
<div class="col-md-4"><label class="form-label">Last Name *</label><input name="last_name" class="form-control custom-input" required value="<?=htmlspecialchars($_POST['last_name']??'')?>"></div>
<div class="col-md-4"><label class="form-label">Department</label><input name="department" class="form-control custom-input" value="<?=htmlspecialchars($_POST['department']??'')?>"></div>
<div class="col-md-4"><label class="form-label">Position</label><input name="position" class="form-control custom-input" value="<?=htmlspecialchars($_POST['position']??'')?>"></div>
<div class="col-md-6"><label class="form-label">Contact Number</label><input name="contact_number" class="form-control custom-input" value="<?=htmlspecialchars($_POST['contact_number']??'')?>"></div>
<div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control custom-input" value="<?=htmlspecialchars($_POST['email']??'')?>"></div>
<div class="col-md-4"><label class="form-label">Status</label><select name="status" class="form-select custom-select"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
</div>
<div class="d-flex gap-2 justify-content-end mt-4"><a href="employees.php" class="btn btn-glass">Cancel</a><button class="btn btn-gradient"><i class="bi bi-check-lg me-2"></i>Save Employee</button></div>
</form></div></main>
<?php include 'includes/footer.php'; ?>