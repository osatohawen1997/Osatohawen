<?php
session_start();

if(!isset($_SESSION['admin_email'])){
    header("Location: ../php/index.php");
}else{
    session_unset();
    session_destroy();
    header("Location: login.php");
}
?>