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
                    <h1 class="page-title">Graphics Project</h1>
                    <div class="page-breadcrumb">
                        <a href="dasboard.php">Dashboard</a>
                        <span>/</span>
                        <span>Graphics project</span>
                    </div>
                </div>
                
            </nav>
            
            <small class='add-btn'>
                <a href="add-graphics-project.php">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#eeeeee"><path d="M440-120v-320H120v-80h320v-320h80v320h320v80H520v320h-80Z"/></svg>
                </i>Add Project</a>
            </small>
            <!-- Web Project Cards -->
            <section style="width: 100%;">
                <div class="glass-card stat-card">
                    <div class="message-count">
                        <div class="stat-icon cyan">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#E07A5F"><path d="M325-111.5q-73-31.5-127.5-86t-86-127.5Q80-398 80-480.5t31.5-155q31.5-72.5 86-127t127.5-86Q398-880 480.5-880t155 31.5q72.5 31.5 127 86t86 127Q880-563 880-480.5T848.5-325q-31.5 73-86 127.5t-127 86Q563-80 480.5-80T325-111.5ZM480-162q26-36 45-75t31-83H404q12 44 31 83t45 75Zm-104-16q-18-33-31.5-68.5T322-320H204q29 50 72.5 87t99.5 55Zm208 0q56-18 99.5-55t72.5-87H638q-9 38-22.5 73.5T584-178ZM170-400h136q-3-20-4.5-39.5T300-480q0-21 1.5-40.5T306-560H170q-5 20-7.5 39.5T160-480q0 21 2.5 40.5T170-400Zm216 0h188q3-20 4.5-39.5T580-480q0-21-1.5-40.5T574-560H386q-3 20-4.5 39.5T380-480q0 21 1.5 40.5T386-400Zm268 0h136q5-20 7.5-39.5T800-480q0-21-2.5-40.5T790-560H654q3 20 4.5 39.5T660-480q0 21-1.5 40.5T654-400Zm-16-240h118q-29-50-72.5-87T584-782q18 33 31.5 68.5T638-640Zm-234 0h152q-12-44-31-83t-45-75q-26 36-45 75t-31 83Zm-200 0h118q9-38 22.5-73.5T376-782q-56 18-99.5 55T204-640Z"/></svg>
                        </div>

                        <div class="stat-info">
                            <h3>Project(s):</h3>
                            <?php
                                graphics();
                            ?>
                        </div>
                       
                    </div>

                    <div class="notification-container">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <span>Graphics Name</span>
                            <span>Action</span>
                        </div>
                        <?php
                            totalGraphics();
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