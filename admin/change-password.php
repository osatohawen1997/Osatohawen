<?php
include "../database-connection/connect-db.php";

include_once "function.php";

session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");

if(!isset($_COOKIE['admin_id'])){

    $adminId = uniqid("admin_", true);
    setcookie("admin_id", "$adminId", 0, "/");

}elseif(!empty($_SESSION['admin_email']) && !empty($_SESSION['otp']) && $_SESSION['otp'] === true){
        
    header("Location: dashboard.php");
    exit;

}else{
    $adminId = $_COOKIE['admin_id'];
    $adminEmail = $_SESSION['admin_email'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="admin-css/style.css">

    <link rel="shortcut icon" href="../images/homepage-image-folder/1765198114796.png" type="image/x-icon">
    
    <title>Osatohawen | Admin Login</title>
</head>
<body>

    <!-- Animated Background -->
    <div class="background"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="login-page">
        <div class="login-container">
            <div class="login-card">
                <?php

                    include_once "project-upload.php";

                ?>
                <?php
                    passwordInput();
                ?>
            </div>
        </div>

    </div>
  
</body>
</html>