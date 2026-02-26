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
    $browser = $_SERVER["HTTP_USER_AGENT"];
    $visitor_id = mysqli_real_escape_string($connect, $userId);

    $cookieSelect = "SELECT * FROM `cookies` WHERE `user_id` = ?";

    $cookieSelectPrep = mysqli_prepare($connect, $cookieSelect);

    $cookieSelectBind = mysqli_stmt_bind_param($cookieSelectPrep, "s", $visitor_id);

    mysqli_stmt_execute($cookieSelectPrep);
    
    if($cookieSelectResult = mysqli_stmt_get_result($cookieSelectPrep)){
        $cookieSelectNum = mysqli_num_rows($cookieSelectResult) > 0;

        if($cookieSelectNum){
            header("Location: homepage.php");
        }else{
            $cookieInsert = "INSERT INTO `cookies` (`user_id`, `ip_address`, `page`, `browser`) VALUES (?, ?, ?, ?)";
        
            $cookieInsertPrep = mysqli_prepare($connect, $cookieInsert);
        
            $cookieInsertBind = mysqli_stmt_bind_param($cookieInsertPrep, "ssss", $visitor_id, $ip, $page, $browser);
        
            mysqli_stmt_execute($cookieInsertPrep);
        
            if($cookieInsertResult = mysqli_stmt_get_result($cookieInsertPrep)){
                header("Location: ../php/homepage.php");
            }else{
                die(mysqli_error($connect));
            }
        }
    }

                
}

?>