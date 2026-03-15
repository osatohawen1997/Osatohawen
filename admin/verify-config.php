<?php
include "../database-connection/connect-db.php";

session_start();

if(!isset($_SESSION['admin_email'])){
    header("Location: ../php/index.php");
}else{
    $adminSession = $_SESSION['admin_email'];

}

$otpSuccess = 0;
$otpFail = 0;
$otpUsedStatus = 0;
$otpExpiredStatus = 0;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $inputOtp = trim(filter_input(INPUT_POST, 'otp', FILTER_SANITIZE_SPECIAL_CHARS));

    $now = date('Y-m-d H:i:s');

    $otpSelect = "SELECT `email`, `otp`, `expiry_time` FROM `otp_code` WHERE `email` = ? LIMIT 1";

    $otpSelectPrep = mysqli_prepare($connect, $otpSelect);

    $otpBind = mysqli_stmt_bind_param($otpSelectPrep, "s", $adminSession);

    mysqli_stmt_execute($otpSelectPrep);

    if($otpSelectResult = mysqli_stmt_get_result($otpSelectPrep)){

        $otpNum = mysqli_num_rows($otpSelectResult) > 0;

        if($otpNum){
            $otpFetch = mysqli_fetch_assoc($otpSelectResult);

            $_SESSION['admin_email'] = $otpFetch['email'];
            $otpVerify = $otpFetch['otp'];
            $unhashOtp = password_verify($inputOtp, $otpVerify);
            $_SESSION['otp'] = $unhashOtp;
            $otpExpired = $otpFetch['expiry_time'];

            if($now > $otpExpired){

                header("Location: verify.php?otp_expired");

            }else{

                if(!$unhashOtp){

                    header("Location: verify.php?invalid");

                }else{

                    header("Location: dashboard.php");
                    $otpDelete = "DELETE FROM `otp_code` WHERE `email` = ?";
    
                    $checkOtpDelete = mysqli_prepare($connect, $otpDelete);
            
                    $checkOtpDeleteBind = mysqli_stmt_bind_param($checkOtpDelete, "s", $adminSession);
                        
                    mysqli_stmt_execute($checkOtpDelete);
                
                }
            }

        }


    }
}

?>