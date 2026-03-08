<?php

include "../database-connection/connect-db.php";

require_once '../vendor/autoload.php';
require_once 'mail.php';

session_start();

if(!isset($_SESSION['admin_email'])){
    header("Location: ../php/index.php");
}else{
    $adminSession = $_SESSION['admin_email'];

}

$success = 0;
$getOtpBtn = 0;

$incorrectOtp = 0;

$expiredOtp = 0;

$errorMsg = 0;

$resendMsg = 0;

$msgFailed = 0;

if(isset($_GET['otp_sent'])){

    $mail   = new Mail();
    
    $otp = (string) random_int(1000, 9999);
    
    $expiredTime = date('Y-m-d H:i:s', strtotime('+5 minutes'));
    
    $createdTime = date('Y-m-d H:i:s');
    
    $result = $mail->send(
        $adminSession,
        'Verify OTP',
        "<h1>OTP Verification</h1>
        <p>Someone is trying to access your admin panel, if this is not you, kindly ignore. <br> <br> OTP expires in 5 minutes.</p>
        <b style='text-align: center; font-size: 1.5rem;'><p>$otp</p></b>"
    );
    
    
    if ($result['success']) {
        $success = 1;
    
        $hashOtp = password_hash($otp, PASSWORD_DEFAULT);
        
        $insertOtp = "INSERT INTO `otp_code` (`email`, `otp`, `created_time`, `expiry_time`) VALUES (?, ?, ?, ?)";
        
        $insertPrep = mysqli_prepare($connect, $insertOtp);
        
        $insertBind = mysqli_stmt_bind_param($insertPrep, "ssss", $adminSession, $hashOtp, $createdTime, $expiredTime);
        
        mysqli_stmt_execute($insertPrep);
        
    } else {
        $errorMsg  = 1;

        header("Location: verify.php?msg_failed");
    }

}elseif(isset($_GET['invalid'])){

    $getOtpBtn = 0;

    $incorrectOtp = 1;

}elseif(isset($_GET['otp_expired'])){
                        
    $getOtpBtn = 1;

    $deleteOtp = "DELETE FROM `otp_code` WHERE `email` = ?";
    
    $checkDeleteOtpPrep = mysqli_prepare($connect, $deleteOtp);
                            
    $checkDeleteOtpBind = mysqli_stmt_bind_param($checkDeleteOtpPrep, "s", $adminSession);
                            
    mysqli_stmt_execute($checkDeleteOtpPrep);

    $expiredOtp = 1;    

}elseif(isset($_GET['msg_failed'])){

    $resendMsg = 1;

    $msgFailed = 1;
    
}else{

    $getOtpBtn = 1;

    $checkOtp = "SELECT * FROM `otp_code` WHERE `email` = ?";

    $checkOtpPrep = mysqli_prepare($connect, $checkOtp);

    $checkOtpBind = mysqli_stmt_bind_param($checkOtpPrep, "s", $adminSession);

    mysqli_stmt_execute($checkOtpPrep);

    if($checkOtpResult = mysqli_stmt_get_result($checkOtpPrep)){
        $checkOtpNum = mysqli_num_rows($checkOtpResult) > 0;

        if($checkOtpNum){
            $otpDelete = "DELETE FROM `otp_code` WHERE `email` = ?";
    
            $checkOtpDelete = mysqli_prepare($connect, $otpDelete);
    
            $checkOtpDeleteBind = mysqli_stmt_bind_param($checkOtpDelete, "s", $adminSession);
                
            mysqli_stmt_execute($checkOtpDelete);
        }
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
                    <h2 class="login-title">Verify if it's you</h2>
                </div>

                <div class="sub-header">
                    <p>Someone is trying to access the admin panel with an unknown IP address, verify if it's you</p>

                    <p>IP Address: </p>

                    <?php

                        if($success){

                            $verifyId = 1;
    
                            $idSelect = "SELECT `admin_email` FROM `admin_login` WHERE `id` = ?";
    
                            $idPrep = mysqli_prepare($connect, $idSelect);
    
                            $idBind =mysqli_stmt_bind_param($idPrep, "s", $verifyId);
    
                            mysqli_stmt_execute($idPrep);
    
                            if($idResult = mysqli_stmt_get_result($idPrep)){
                                $idFetch = mysqli_fetch_assoc($idResult);
    
                                $verifyEmail = $idFetch['admin_email'];
                                
                                echo"
                                    <small>OTP has been sent to $verifyEmail</small>
                                ";
    
                            }else{
                                die(mysqli_error($connect));
                            }

                            var_dump($otp);
                        }
                    ?>
                    
                </div>

                <?php
                    if($expiredOtp){
                        echo"
                        
                            <div class='alert-failed'>
                                OTP time has expired. Get a new OTP.
                            </div>
                        ";
                    }
                ?>
                <?php
                
                    if($incorrectOtp){
                        echo"
                        
                            <div class='alert-failed'>
                                Incorrect OTP, Try again.
                            </div>
                        ";
                    }
                    
                ?>

                <?php
                
                    if($msgFailed){
                        echo"
                        
                            <div class='alert-failed'>
                                Internal error occur while trying to send OTP. Kindly resend it.
                            </div>
                        ";
                    }
                    
                ?>


                <form action="verify-config.php" method='POST'>

                    <div class="form-group" style="display: flex; column-gap: 10px;">
                        <input type="number" name="otp" class="form-input" style='text-align: center;' placeholder="Enter the OTP" required autocomplete="off">
                        
                        <?php
                            if($getOtpBtn){
                                echo"
                                
                                <a href='verify.php?otp_sent' style='color: white; text-align: center; padding: 10px 10px; font-size: 12px; background: green; border-radius: 12px;'>Get OTP</a>

                                ";
                            }
                        ?>

                        <?php
                            if($resendMsg){
                                echo"
                                
                                <a href='verify.php?otp_sent' style='color: white; text-align: center; padding: 10px 10px; font-size: 12px; background: green; border-radius: 12px;'>Resend OTP</a>

                                ";
                            }
                        ?>
                    </div>

                    <button type="submit" name="verify" class="btn btn-primary">
                        Enter
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </button>
                    <a class='logout btn' style='width: 100%; color: #ec0000; text-align: center; margin-top: 10px;' href="logout.php">Log out <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ec0000"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg></a>
                </form>
            </div>
        </div>

    </div>
    
</body>
</html>