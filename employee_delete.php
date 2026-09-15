<?php
require_once 'includes/auth.php';require_roles(['admin','inventory_staff']);require_once 'config/db.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location: employees.php');exit;}
$id=(int)($_POST['id']??0);
try{
    $s=$pdo->prepare("SELECT COUNT(*) FROM mr_records WHERE employee_id=?");$s->execute([$id]);
    if((int)$s->fetchColumn()>0){header('Location: employees.php?error=assigned');exit;}
    $s=$pdo->prepare("DELETE FROM employees WHERE id=?");$s->execute([$id]);
}catch(PDOException $e){}
header('Location: employees.php?deleted=1');exit;
?>