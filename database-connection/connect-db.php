<?php

$localhost = "localhost";
$username = "root";
$password = "";
$database = "portfolio";

$connect = mysqli_connect($localhost, $username, $password, $database);

if(!$connect){
    die(mysqli_error($connect));
}

?>