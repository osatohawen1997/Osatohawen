<?php

include "../database-connection/connect-db.php";
require_once __DIR__ . '/../vendor/autoload.php';

use BrowscapPHP\Browscap;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use MatthiasMullie\Scrapbook\Adapters\Flysystem as FlysystemAdapter;
use MatthiasMullie\Scrapbook\Psr16\SimpleCache;
use Psr\Log\NullLogger;

$adapter    = new LocalFilesystemAdapter(__DIR__ . '/../cache');
$filesystem = new Filesystem($adapter);
$pool       = new FlysystemAdapter($filesystem);
$cache      = new SimpleCache($pool);

$bc   = new Browscap($cache, new NullLogger());
$info = $bc->getBrowser();


if(isset($_GET['cookie'])){
    
    if(!isset($_COOKIE['user_id'])){
       header("Location: ../php/homepage.php");
    }else{
        $userId = $_COOKIE['user_id'];
        header("Location: ../php/homepage.php");
    }
    
    $ip = $_SERVER["REMOTE_ADDR"];
    $page = $_SERVER["REQUEST_URI"];
    
    $user_browser = $info->browser;
    $user_os = $info->platform;
    $browser_version = $info->version;
    $user_device = $info->ismobiledevice;
    $device = $user_device == 1 ? "mobile" : "PC";

    $visitor_id = mysqli_real_escape_string($connect, $userId);

    $cookieSelect = "SELECT * FROM `cookies` WHERE `ip_address` = ?";

    $cookieSelectPrep = mysqli_prepare($connect, $cookieSelect);

    $cookieSelectBind = mysqli_stmt_bind_param($cookieSelectPrep, "s", $ip);

    mysqli_stmt_execute($cookieSelectPrep);
    
    if($cookieSelectResult = mysqli_stmt_get_result($cookieSelectPrep)){
        $cookieSelectNum = mysqli_num_rows($cookieSelectResult) > 0;

        if($cookieSelectNum){
            
            $browserFetch = mysqli_fetch_assoc($cookieSelectResult);

            $browserType = $browserFetch['browser'];

            if($user_browser != $browserType){

                $browserUpdate = "INSERT INTO `cookies` (`user_id`, `ip_address`, `page`, `browser`, `browser_version`, `user_os`, `user_device`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
                $browserUpdatePrep = mysqli_prepare($connect, $browserUpdate);
            
                $browserUpdateBind = mysqli_stmt_bind_param($browserUpdatePrep, "sssssss", $visitor_id, $ip, $page, $user_browser, $browser_version, $user_os, $device);
            
                if(mysqli_stmt_execute($browserUpdatePrep)){
                    header("Location: ../php/homepage.php");
                }else{
                    die(mysqli_error($connect));
                }
            }

        }else{

            $cookieInsert = "INSERT INTO `cookies` (`user_id`, `ip_address`, `page`, `browser`, `browser_version`, `user_os`, `user_device`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
            $cookieInsertPrep = mysqli_prepare($connect, $cookieInsert);
        
            $cookieInsertBind = mysqli_stmt_bind_param($cookieInsertPrep, "sssssss", $visitor_id, $ip, $page, $user_browser, $browser_version, $user_os, $device);
        
            if(mysqli_stmt_execute($cookieInsertPrep)){
                header("Location: ../php/homepage.php");
            }else{
                die(mysqli_error($connect));
            }

        }
    }

                
}else{
    header("Location: ../php/homepage.php");
}

header("Location: ../php/homepage.php");
exit();

?>
