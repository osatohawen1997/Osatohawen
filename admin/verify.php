<?php

session_start();

if(!isset($_SESSION['admin_email'])){
    header("Location: ../php/index.php");
}else{
    $adminSession = $_SESSION['admin_email'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="admin-css/style.css">

    <link rel="shortcut icon" href="../images/homepage-image-folder/1765198114796.png" type="image/x-icon">
    
    <title>Osatohawen | Admin Login</title>
</head>
<body>
    <!-- Animated Background -->
    <div class="background"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="login-page">
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <h2 class="login-title">Verify if it's you</h2>
                </div>

                <div class="sub-header">
                    <p>Someone is trying to access the admin panel with an unknown IP address, verify if it's you</p>

                    <p>IP Address: </p>

                    <small>OTP has been sent to Idahosavictor925@gmail.com</small>
                </div>

                <?php

                    // if($adminCreateError){
                    //     echo"
                        
                    //         <div class='alert-failed'>
                    //             Error Creating Admin.
                    //         </div>
                    //     ";
                    // }

                ?>

                <?php
                    // if($loginSuccess){
                    //     echo"
                        
                    //         <div class='alert-success'>
                    //             Logged in Successfully.
                    //         </div>
                    //     ";
                    // }
                ?>

                <form method='POST'>
                    <div class="form-group">
                        <input type="number" name="otp" class="form-input" style='text-align: center;' placeholder="Enter the OTP" required autocomplete="off">
                    </div>

                    <button type="submit" name="login" class="btn btn-primary">
                        Enter
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </button>
                </form>

                <a class='logout' style='color: red; text-align: center; margin-top: 50px; border: 1px solid green;' href="logout.php">Log out</a>
                
            </div>
        </div>

    </div>
    
</body>
</html>