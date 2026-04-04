<?php

$timeout = 1200;

if (isset($_SESSION['last_activity'])) {

    $idle = time() - $_SESSION['last_activity'];

    if ($idle > $timeout) {
        
        header("Location: logout.php");

        exit();

    }
}

$_SESSION['last_activity'] = time(); // reset timer on each request