<?php
session_start();

$_SESSION = [];

// Destroy the session cookie
if(ini_get("session.use_cookies")){
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

if(!isset($_SESSION['admin_email'])){
    header("Location: login.php");
}else{
    session_unset();
    session_destroy();
    header("Location: login.php");
}
?>