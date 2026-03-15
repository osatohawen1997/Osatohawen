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


include "otp.php";
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

                    <p>IP Address: 

                        <?php
                            $idVerify = 1;

                            $ipSelect = "SELECT `admin_ip` FROM `admin_login` WHERE `id` = ?";
    
                            $ipPrep = mysqli_prepare($connect, $ipSelect);
    
                            $ipBind =mysqli_stmt_bind_param($ipPrep, "s", $idVerify);
    
                            mysqli_stmt_execute($ipPrep);
    
                            if($ipResult = mysqli_stmt_get_result($ipPrep)){
                                $ipFetch = mysqli_fetch_assoc($ipResult);
    
                                $verifyIp = $ipFetch['admin_ip'];
                                
                                echo"
                                    <small>$verifyIp</small>
                                ";
    
                            }else{
                                die(mysqli_error($connect));
                            }
                        ?>

                    </p>

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
                                Internal error occur while trying to send OTP. Kindly resend OTP.
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