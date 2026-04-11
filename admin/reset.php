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


$emailError = 0;

$adminError = 0;

$errorMsg = 0;

$success = 0;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    include_once "decrypt.php";
    include_once "mail.php";

    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);

    $sql = "SELECT `admin_email` FROM `admin_login`";

    $sqlPrep = mysqli_prepare($connect, $sql);

    mysqli_stmt_execute($sqlPrep);

    if($sqlResult = mysqli_stmt_get_result($sqlPrep)){

        $sqlNum = mysqli_num_rows($sqlResult) > 0;

        if($sqlNum){

            $linkId = uniqid("reset_", true);

            $createdDate = date("Y-m-d H:i:s");

            $expiredDate = date("Y-m-d H:i:s", strtotime("+10 minutes"));

            $sqlFetch = mysqli_fetch_assoc($sqlResult);

            $_SESSION['admin_email'] = decryptdata($sqlFetch['admin_email'], $key);

            if($email === $_SESSION['admin_email']){

                $mail = new Mail();

                $result = $mail->send(
                    $email,
                    'Forgot Password',
                    "<h1>Reset Password</h1>
                    <p>Click the button below to reset password, link will expire in 10 minutes. if you did not authorize this action, kindly ignore.</p> <br> <br>
                    <a href='http://localhost/osatohawen/admin/change-password.php?r=$linkId' style='text-align: center; padding: 10px 17px; background: #0073df; color: #ffff; border-radius: 5px;'>Click to reset password</a>"
                );
                
                
                if($result['success']){

                    $insertSuccess = "INSERT INTO `reset_password` (`email`, `link_id`, `created_time`, `expire_time`) VALUES (?, ?, ?, ?)";

                    $insertSuccessPrep = mysqli_prepare($connect, $insertSuccess);

                    $insertSuccessBind = mysqli_stmt_bind_param($insertSuccessPrep, "ssss", $email, $linkId, $createdDate, $expiredDate);

                    if(mysqli_stmt_execute($insertSuccessPrep)){

                        $success = 1;

                    }else{
                        die(mysqli_error($connect));
                    }
 
                }else{

                    $errorMsg  = 1;
                    
                }


            }else{
                $emailError = 1;
            }
            
        }else{

            $adminError = 1;

        }

    }else{

        die(mysqli_error($connect));

    }

}else{

$delete = "DELETE FROM `reset_password`";

$deletePrep = mysqli_prepare($connect, $delete);

mysqli_stmt_execute($deletePrep);

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
                    <h2 class="login-title">Reset Password</h2>
                </div>

                <?php
                    if($errorMsg){
                        echo"
                        
                            <div class='alert-failed'>
                                Network error trying to verify email address, try again.
                            </div>
                        ";
                    }
                ?>

                <?php
                    if($adminError){
                        echo"
                        
                            <div class='alert-failed'>
                                No Registered Email.
                            </div>
                        ";
                    }
                ?>

                <?php

                    if($emailError){
                        echo"
                        
                            <div class='alert-failed'>
                                Email Address does not exist.
                            </div>
                        ";
                    }

                ?>

                <?php

                    if($success){
                        echo"
                        
                            <div class='alert-success'>
                                Reset password link has been sent to your email.
                            </div>
                        ";
                    }
                ?>

                <form method='POST'>
                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <input type="email" name="email" class="form-input" placeholder="Enter your email" required autocomplete="off">
                    </div>

                    <button type="submit" name="login" class="btn btn-primary">Verify Email</button>

                    <p style='text-align: center; margin-top: 20px; color: red;'>
                        <a href='login.php'>Go back</a>
                    </p>
                </form>
            </div>
        </div>

    </div>

    
</body>
</html>