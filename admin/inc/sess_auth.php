<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// تحديد البروتوكول الصحيح
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $link = "https"; 
} else {
    $link = "http"; 
}

$link .= "://"; 
$link .= $_SERVER['HTTP_HOST']; 
$link .= $_SERVER['REQUEST_URI'];

// فحص حالة الجلسة وتوجيه المستخدمين
if(!isset($_SESSION['userdata']) && !strpos($link, 'login.php')){
    redirect('admin/login.php');
}

if(isset($_SESSION['userdata']) && strpos($link, 'login.php')){
    redirect('admin/index.php');
}

// تحديد وحدة المستخدم (الإدارة، الهيئة التدريسية، الطلاب)
$module = array('','admin','faculty','student');

// فحص صلاحيات الوصول
if(isset($_SESSION['userdata']) && (strpos($link, 'index.php') || strpos($link, 'admin/')) && $_SESSION['userdata']['login_type'] !=  1){
    echo "<script>alert('تم رفض الوصول!');location.replace('".base_url.$module[$_SESSION['userdata']['login_type']]."');</script>";
    exit;
}
?>
