<?php

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
