<?php

$localhost = "localhost";
$username = "root";
$password = "";
$database = "portfolio";

$connect = mysqli_connect($localhost, $username, $password, $database);

if(!$connect){
    mysqli_error($connect);
}else{
    header("Location: ../php/index.php");
}

exit();

?>