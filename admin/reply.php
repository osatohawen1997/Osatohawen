<?php

include "../database-connection/connect-db.php";

include "function.php";

session_start();

if(!isset($_SESSION['admin_email'])){
    
    header("Location: login.php");
    exit();
    
}elseif(empty($_SESSION['otp'])){

    header("Location: verify.php");
    exit();
        
}else{
    
    $adminSession = $_SESSION['admin_email'];

    require __DIR__ . "/auto-logout.php";

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
    <link rel="stylesheet" href="admin-css/custom-css.css">

    <link rel="shortcut icon" href="../images/homepage-image-folder/1765198114796.png" type="image/x-icon">
    
    <title>Osatohawen | Admin Panel</title>
</head>
<body>
    <!-- Animated Background -->
    <div class="background"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <?php
                include_once "side-bar.php";
            ?>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Navbar -->
            <nav class="navbar">
                <div class="page-header">
                    <h1 class="page-title">Notification</h1>
                    <div class="page-breadcrumb">
                        <a href="dashboard.php">Dashboard</a>
                        <span>/</span>
                        <span>Notification</span>
                    </div>
                </div>
               
            </nav>

            <?php

                include_once "../php/user-mail.php";
                include_once "../php/encrypt.php";
                
                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['to'])){
                    
                    $id = $_GET['to'];
                    
                    $fullName = filter_input(INPUT_POST, 'name',FILTER_SANITIZE_SPECIAL_CHARS);
                    
                    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
                    
                    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
                    
                    // Encrypting Data
                    
                    $iv = openssl_random_pseudo_bytes(16);
                    $encryptFullName = encryptData($fullName, $key);

                    $encryptEmail = encryptData($email, $key);
                    
                    $encryptMsg = encryptData($message, $key);
                    
                    
                    $msgId = "SELECT * FROM `message` WHERE `message_id` = ?";
    
                    $msgIdPrep = mysqli_prepare($connect, $msgId);
    
                    $msgIdBind = mysqli_stmt_bind_param($msgIdPrep, "s", $id);
    
                    mysqli_stmt_execute($msgIdPrep);
    
                    $msgIdResult = mysqli_stmt_get_result($msgIdPrep);
    
                    $msgIdFetch = mysqli_fetch_assoc($msgIdResult);
                    
                    $messageId = $msgIdFetch['message_id'];

                    // Sending Mail
                    
                    $mail   = new Mail();

                    $result = $mail->send(
                        $email,
                        'Incoming Notification',
                        "<h1 style='color: #2093ff;'>New message from Osatohawen</h1>
                        <p style='font-size: 1rem;'>$message</p> <br> <br> <br>
                        <a href='https://osatohawen.com/php/index.php' style='text-decoration:none; text-align: center; font-size: 1.1rem; padding: 8px 18px; background: #2093ff; color: #ffff; border-radius: 5px;'>Explore portfolio</a>"
                    );
                    
                    
                    if ($result['success']) {

                        
                        $insertMsg = "INSERT INTO `reply_message` (`full_name`, `email`, `message`, `message_id`) VALUES (?, ?, ?, ?)";
                        
                        $insertPrep = mysqli_prepare($connect, $insertMsg);
                        
                        $insertBind = mysqli_stmt_bind_param($insertPrep, "ssss", $encryptFullName, $encryptEmail, $encryptMsg, $messageId);
                        
                        mysqli_stmt_execute($insertPrep);

                        echo"
                            <script>
                                alert('Message sent successfully');

                                window.location.href='notification.php';
                            </script>
                        ";
                        
                    }else{

                        echo"
                            <script>
                                alert('Message was not sent, Try again.');

                                window.location.href='notification.php';
                            </script>
                        ";

                    }
                   
                }
            ?>

            <!-- Notification Cards -->
            <section style="width: 100%;">
                <div class="glass-card stat-card">
                    <div class="notification-container">
                        
                        <form method='POST'>
                            <?php
                                formInput();
                            ?>

                            <div class="form-group">
                                <label class="form-label" for="message">Message</label>
                                <textarea class="form-input"  required rows='10' placeholder='Type a message' name="message"></textarea>
                            </div>

                            <button type="submit" name="login" class="btn btn-primary">
                                Submit
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffff"><path d="M120-160v-640l760 320-760 320Zm80-120 474-200-474-200v140l240 60-240 60v140Zm0 0v-400 400Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                
            </section>
        </main>
    </div>

    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
    </button>

    <script src="admin-javascript/script.js"></script>
</body>
</html>