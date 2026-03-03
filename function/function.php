<?php

include "../database-connection/connect-db.php";


if(!isset($_COOKIE['user_id'])){
   header("Location: ../php/homepage.php");
}else{
    $userId = $_COOKIE['user_id'];
    header("Location: ../php/homepage.php");
}

?>

<?php
if(isset($_GET['cookie'])){

    $ip = $_SERVER["REMOTE_ADDR"];
    $page = $_SERVER["REQUEST_URI"];
    $browser = get_browser(null, true);

    $user_browser = $browser['browser'];
    $user_os = $browser['platform'];
    $browser_version = $browser['version'];
    $user_device = $browser['isitmobiledevice'];

    $visitor_id = mysqli_real_escape_string($connect, $userId);

    $cookieSelect = "SELECT * FROM `cookies` WHERE `ip_address` = ?";

    $cookieSelectPrep = mysqli_prepare($connect, $cookieSelect);

    $cookieSelectBind = mysqli_stmt_bind_param($cookieSelectPrep, "s", $ip);

    mysqli_stmt_execute($cookieSelectPrep);
    
    if($cookieSelectResult = mysqli_stmt_get_result($cookieSelectPrep)){
        $cookieSelectNum = mysqli_num_rows($cookieSelectResult) > 0;

        if($cookieSelectNum){
            header("Location: homepage.php");
        }else{

            if($user_device == 1){

                $mobileDevice = "mobile";

                $cookieInsert = "INSERT INTO `cookies` (`user_id`, `ip_address`, `page`, `browser`, `browser_version`, `user_os`, `user_device`) VALUES (?, ?, ?, ?, ?, ?, ?)";
            
                $cookieInsertPrep = mysqli_prepare($connect, $cookieInsert);
            
                $cookieInsertBind = mysqli_stmt_bind_param($cookieInsertPrep, "sssssss", $visitor_id, $ip, $page, $user_browser, $browser_version, $user_os, $mobileDevice);
            
                mysqli_stmt_execute($cookieInsertPrep);
            
                if($cookieInsertResult = mysqli_stmt_get_result($cookieInsertPrep)){
                    header("Location: ../php/homepage.php");
                }else{
                    die(mysqli_error($connect));
                }

            }else{

                $pc = "PC";

                $cookieInsert = "INSERT INTO `cookies` (`user_id`, `ip_address`, `page`, `browser`, `browser_version`, `user_os`, `user_device`) VALUES (?, ?, ?, ?, ?, ?, ?)";
            
                $cookieInsertPrep = mysqli_prepare($connect, $cookieInsert);
            
                $cookieInsertBind = mysqli_stmt_bind_param($cookieInsertPrep, "sssssss", $visitor_id, $ip, $page, $user_browser, $browser_version, $user_os, $pc);
            
                mysqli_stmt_execute($cookieInsertPrep);
            
                if($cookieInsertResult = mysqli_stmt_get_result($cookieInsertPrep)){
                    header("Location: ../php/homepage.php");
                }else{
                    die(mysqli_error($connect));
                }

            }

        }
    }

                
}

?>