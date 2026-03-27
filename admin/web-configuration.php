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
                    <h1 class="page-title">Web Configuration</h1>
                    <div class="page-breadcrumb">
                        <a href="dashboard.php">Dashboard</a>
                        <span>/</span>
                        <span>Web configuration</span>
                    </div>
                </div>
               
            </nav>

            

            <!-- Notification Cards -->
            <section style="width: 100%; margin-bottom: 20px;">
                <div class="glass-card stat-card">
                    <div class="notification-container">

                        <h3>Intro Section</h3>

                        <hr>

                        <?php
                            include_once "project-upload.php";
                        
                            configInput();
                        ?>
                        
                    </div>
                </div>

                
            </section>

            <section style="width: 100%;">
                <div class="glass-card stat-card">
                    <div class="notification-container">

                        <h3>Social Links</h3>

                        <hr>

                        <?php
                            include_once "project-upload.php";
                        
                            configInputSocial();
                        ?>
                        
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