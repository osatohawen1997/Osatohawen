<?php
include "../database-connection/connect-db.php";

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
}


$cookieNotExist = 0;

$EmailPasswordError = 0;

$loginSuccess = 0;

$adminCreate = 0;

$adminCreateError = 0;

$internalError = 0;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    
    include_once "../php/encrypt.php";
    include_once "decrypt.php";

    $adminIp = $_SERVER['REMOTE_ADDR'];

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    $emailHash = encryptdata($email, $key);
    $passwordHash =  password_hash($password, PASSWORD_DEFAULT);

    $sqlCheck = "SELECT * FROM `admin_login`";

    $sqlPrep = mysqli_prepare($connect, $sqlCheck);

    mysqli_stmt_execute($sqlPrep);

    if($sqlResult = mysqli_stmt_get_result($sqlPrep)){
        $sqlNum = mysqli_num_rows($sqlResult) > 0;

        if($sqlNum){

            $id = 1;

            $adminLogin = "SELECT `admin_email`, `admin_password`, `admin_ip` FROM `admin_login` WHERE id = ?";

            $adminLoginPrep = mysqli_prepare($connect, $adminLogin);

            $adminLoginBind = mysqli_stmt_bind_param($adminLoginPrep, 's', $id);

            mysqli_stmt_execute($adminLoginPrep);

            if($adminLoginResult = mysqli_stmt_get_result($adminLoginPrep)){

                $adminLoginNum = mysqli_num_rows($adminLoginResult) > 0;

                if($adminLoginNum){

                    $adminLoginFetch = mysqli_fetch_assoc($adminLoginResult);

                    $_SESSION['admin_email'] = decryptdata($adminLoginFetch['admin_email'], $key);

                    $passwordVerify = $adminLoginFetch['admin_password'];

                    $ipVerify = $adminLoginFetch['admin_ip'];

                    $passwordUnhash = password_verify($password, $passwordVerify);

                    if($email !== $_SESSION['admin_email']){

                        $EmailPasswordError = 1;

                    }elseif(!$passwordUnhash){

                        $EmailPasswordError = 1;

                    }else{

                        session_regenerate_id(true);

                        if($adminIp != $ipVerify){
                            
                            header("Location: verify.php");
                        }else{
                            header("Location: dashboard.php");
                        }

                    }
                }

            }else{
                $internalError = 1;
            }

        }else{

            $adminInsert =  "INSERT INTO `admin_login` (`admin_email`, `admin_password`, `admin_ip`) VALUES (?, ?, ?)";

            $adminPrep = mysqli_prepare($connect, $adminInsert);

            $adminBind = mysqli_stmt_bind_param($adminPrep, "sss", $emailHash, $passwordHash, $adminIp);    

            if(mysqli_stmt_execute($adminPrep)){

                $adminCreate = 1;

            }else{
                $adminCreateError = 1;
            }
        }

    }else{
        die(mysqli_error($connect));
    }

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
                <div class="login-header">
                    <h2 class="login-title">Admin Panel</h2>
                </div>

                <?php
                    if($adminCreate){
                        echo"
                        
                            <div class='alert-success'>
                                Admin Created Successfully.
                            </div>
                        ";
                    }
                ?>

                <?php

                    if($adminCreateError){
                        echo"
                        
                            <div class='alert-failed'>
                                Error Creating Admin.
                            </div>
                        ";
                    }

                ?>

                <?php

                    if($internalError){
                        echo"
                        
                            <div class='alert-failed'>
                                Internal Error Occur.
                            </div>
                        ";
                    }
                ?>

                <?php

                    if($EmailPasswordError){
                        echo"
                        
                            <div class='alert-failed'>
                                Incorrect Email or Password, Try again.
                            </div>
                        ";
                    }
                ?>

                <?php
                    if($loginSuccess){
                        echo"
                        
                            <div class='alert-success'>
                                Logged in Successfully.
                            </div>
                        ";
                    }
                ?>

                <form method='POST'>
                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <input type="email" name="email" class="form-input" placeholder="Enter your email" required autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" name="password" class="form-input" placeholder="Enter your password" required>

                        <small>
                            <a href="reset.php" class="mt-3">Forgot Password?</a>
                        </small>
                    </div>

                    <button type="submit" name="login" class="btn btn-primary">
                        Sign In
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

    </div>

    
</body>
</html>