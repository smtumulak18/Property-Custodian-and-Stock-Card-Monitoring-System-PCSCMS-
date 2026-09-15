<?php
require_once 'includes/auth.php';require_roles(['admin']);require_once 'config/db.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $id=(int)($_POST['id']??0);
    $s=$pdo->prepare("SELECT status FROM users WHERE id=? AND role='inventory_staff'");$s->execute([$id]);$u=$s->fetch();
    if($u){$new=$u['status']==='active'?'inactive':'active';$s=$pdo->prepare("UPDATE users SET status=? WHERE id=? AND role='inventory_staff'");$s->execute([$new,$id]);}
}
header('Location: accounts.php');exit;
?>