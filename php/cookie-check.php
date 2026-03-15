<?php

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

$user_browser = $info->browser;

$cookieExistPopOut = 0;

$cookiePopOut = 0;

$ip_address = $_SERVER['REMOTE_ADDR'];

$sqlSelect = "SELECT * FROM `cookies` WHERE `ip_address` = ? AND `browser` = ?";

$cookiePrep = mysqli_prepare($connect, $sqlSelect);

$cookieBindUpdate =  mysqli_stmt_bind_param($cookiePrep, "ss", $ip_address, $user_browser);

mysqli_stmt_execute($cookiePrep);

if($cookieResult = mysqli_stmt_get_result($cookiePrep)){
    $cookieNum = mysqli_num_rows($cookieResult) > 0;
    if(!$cookieNum){
        $cookieExistPopOut = 1;
    }else{
        $cookiePopOut = 1;

        $sqlUpdate = "UPDATE `cookies` SET `visit_time` = NOW() WHERE `ip_address` = ? AND `browser` = ?";

        $cookiePrepUpdate = mysqli_prepare($connect, $sqlUpdate);

        $cookieBindUpdate =  mysqli_stmt_bind_param($cookiePrepUpdate, "ss", $ip_address, $user_browser);

        mysqli_stmt_execute($cookiePrepUpdate);
    }
}else{
    die(mysqli_error());
}