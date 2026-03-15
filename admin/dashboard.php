<?php

include "../database-connection/connect-db.php";

include "function.php";

session_start();

if(!isset($_SESSION['admin_email'])){
    
    header("Location: login.php");
    
}elseif(!isset($_SESSION['otp'])){

    header("Location: verify.php");
        
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
            <div class="sidebar-header">
                <div class="logo">O</div>
                <span class="logo-text">Osatohawen</span>
            </div>

            <ul class="nav-menu">
                <li class="nav-section">
                    <span class="nav-section-title">Main Menu</span>
                    <ul>
                        <li class="nav-item">
                            <a href="dashboard.php" class="nav-link active">
                                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="notification.php" class="nav-link">
                                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                    <path d="M2 17l10 5 10-5"/>
                                    <path d="M2 12l10 5 10-5"/>
                                </svg>
                                Notification
                                <span class="nav-badge">1</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="project.html" class="nav-link">
                                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                                Projects
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="tech-stack.html" class="nav-link">
                                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                                Tech Stacks
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="skills.html" class="nav-link">
                                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                                Skills
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="web-configuration.html" class="nav-link">
                                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="3"/>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                                </svg>
                                Web Configuration
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-section">
                    <span class="nav-section-title">Account</span>
                    <ul>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link">
                                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                    <polyline points="16 17 21 12 16 7"/>
                                    <line x1="21" y1="12" x2="9" y2="12"/>
                                </svg>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Navbar -->
            <nav class="navbar" style="display: flex; flex-direction: row-reverse;">
                <div class="navbar-right">
                    <a href='notification.php' class="nav-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        </svg>
                        <span class="notification-dot"></span>
                    </a>
                </div>
                <h1 class="page-title">Admin Dashboard</h1>
            </nav>

            <!-- Stats Cards -->
            <section class="stats-grid">

                <div class="glass-card stat-card">
                    <div class="stat-card-inner">
                        <div class="stat-info">
                            <h3>Visited Users</h3>
                            <?php 
                                visitedUsers();
                            ?>
                            <span class="stat-change positive">
                                <?php 
                                    todayUser();
                                ?>
                            </span>
                        </div>
                        <div class="stat-icon magenta">
                            <svg viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                    </div>
                </div>


                <div class="glass-card stat-card">
                    <div class="stat-card-inner">
                        <div class="stat-info">
                            <h3>Total Message</h3>
                            <?php
                                message();
                            ?>
                            <span class="stat-change positive">
                                <?php
                                todayMessage();
                            ?>
                            </span>
                        </div>
                        <div class="stat-icon cyan">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#2093FF"><path d="M240-400h320v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="glass-card stat-card">
                    <div class="stat-card-inner">
                        <div class="stat-info">
                            <h3>Website Projects</h3>
                            <?php
                                webProject();
                            ?>
                            <!-- <span class="stat-change negative">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/></svg>
                                -3.1%
                            </span> -->
                        </div>
                        <div class="stat-icon purple">
                           <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#E07A5F"><path d="M325-111.5q-73-31.5-127.5-86t-86-127.5Q80-398 80-480.5t31.5-155q31.5-72.5 86-127t127.5-86Q398-880 480.5-880t155 31.5q72.5 31.5 127 86t86 127Q880-563 880-480.5T848.5-325q-31.5 73-86 127.5t-127 86Q563-80 480.5-80T325-111.5ZM480-162q26-36 45-75t31-83H404q12 44 31 83t45 75Zm-104-16q-18-33-31.5-68.5T322-320H204q29 50 72.5 87t99.5 55Zm208 0q56-18 99.5-55t72.5-87H638q-9 38-22.5 73.5T584-178ZM170-400h136q-3-20-4.5-39.5T300-480q0-21 1.5-40.5T306-560H170q-5 20-7.5 39.5T160-480q0 21 2.5 40.5T170-400Zm216 0h188q3-20 4.5-39.5T580-480q0-21-1.5-40.5T574-560H386q-3 20-4.5 39.5T380-480q0 21 1.5 40.5T386-400Zm268 0h136q5-20 7.5-39.5T800-480q0-21-2.5-40.5T790-560H654q3 20 4.5 39.5T660-480q0 21-1.5 40.5T654-400Zm-16-240h118q-29-50-72.5-87T584-782q18 33 31.5 68.5T638-640Zm-234 0h152q-12-44-31-83t-45-75q-26 36-45 75t-31 83Zm-200 0h118q9-38 22.5-73.5T376-782q-56 18-99.5 55T204-640Z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="glass-card stat-card">
                    <div class="stat-card-inner">
                        <div class="stat-info">
                            <h3>Graphics Design Projects</h3>
                            <?php
                                graphicProject();
                            ?>
                        </div>
                        <div class="stat-icon success">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#22C55E"><path d="M480-80q-82 0-155-31.5t-127.5-86Q143-252 111.5-325T80-480q0-83 32.5-156t88-127Q256-817 330-848.5T488-880q80 0 151 27.5t124.5 76q53.5 48.5 85 115T880-518q0 115-70 176.5T640-280h-74q-9 0-12.5 5t-3.5 11q0 12 15 34.5t15 51.5q0 50-27.5 74T480-80Zm0-400Zm-177 23q17-17 17-43t-17-43q-17-17-43-17t-43 17q-17 17-17 43t17 43q17 17 43 17t43-17Zm120-160q17-17 17-43t-17-43q-17-17-43-17t-43 17q-17 17-17 43t17 43q17 17 43 17t43-17Zm200 0q17-17 17-43t-17-43q-17-17-43-17t-43 17q-17 17-17 43t17 43q17 17 43 17t43-17Zm120 160q17-17 17-43t-17-43q-17-17-43-17t-43 17q-17 17-17 43t17 43q17 17 43 17t43-17ZM480-160q9 0 14.5-5t5.5-13q0-14-15-33t-15-57q0-42 29-67t71-25h70q66 0 113-38.5T800-518q0-121-92.5-201.5T488-800q-136 0-232 93t-96 227q0 133 93.5 226.5T480-160Z"/></svg>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Content Grid -->
            <section class="content-grid">
                <!-- Chart Card -->
                <div class="glass-card chart-card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-title">Revenue Analytics</h2>
                            <p class="card-subtitle">Monthly revenue overview</p>
                        </div>
                        <div class="card-actions">
                            <button class="card-btn active">Monthly</button>
                            <button class="card-btn">Weekly</button>
                            <button class="card-btn">Daily</button>
                        </div>
                    </div>
                    <div class="chart-wrapper">
                        <div class="chart-container">
                            <div class="chart-y-axis">
                                <span class="y-value">$100K</span>
                                <span class="y-value">$80K</span>
                                <span class="y-value">$60K</span>
                                <span class="y-value">$40K</span>
                                <span class="y-value">$20K</span>
                                <span class="y-value">$0</span>
                            </div>
                            <div class="chart-placeholder">
                                <div class="chart-bar-group"><div class="chart-bar bar-emerald" style="height: 120px;"></div><span class="chart-label">Jan</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-gold" style="height: 160px;"></div><span class="chart-label">Feb</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-coral" style="height: 90px;"></div><span class="chart-label">Mar</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-teal" style="height: 140px;"></div><span class="chart-label">Apr</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-amber" style="height: 180px;"></div><span class="chart-label">May</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-emerald" style="height: 130px;"></div><span class="chart-label">Jun</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-gold" style="height: 170px;"></div><span class="chart-label">Jul</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-coral" style="height: 150px;"></div><span class="chart-label">Aug</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-teal" style="height: 190px;"></div><span class="chart-label">Sep</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-amber" style="height: 140px;"></div><span class="chart-label">Oct</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-emerald" style="height: 175px;"></div><span class="chart-label">Nov</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-gold" style="height: 200px;"></div><span class="chart-label">Dec</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Feed -->
                <div class="glass-card activity-card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-title">Recent Activity</h2>
                            <p class="card-subtitle">Latest transactions</p>
                        </div>
                    </div>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-avatar" style="background: linear-gradient(135deg, var(--emerald-light), var(--emerald));">JD</div>
                            <div class="activity-content">
                                <p class="activity-text"><strong>John Doe</strong> purchased Premium Plan</p>
                                <span class="activity-time">2 minutes ago</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-avatar" style="background: linear-gradient(135deg, var(--gold), var(--amber));">AS</div>
                            <div class="activity-content">
                                <p class="activity-text"><strong>Anna Smith</strong> submitted a support ticket</p>
                                <span class="activity-time">15 minutes ago</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-avatar" style="background: linear-gradient(135deg, var(--coral), var(--gold));">MJ</div>
                            <div class="activity-content">
                                <p class="activity-text"><strong>Mike Johnson</strong> upgraded subscription</p>
                                <span class="activity-time">1 hour ago</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-avatar" style="background: linear-gradient(135deg, var(--success), var(--emerald));">EW</div>
                            <div class="activity-content">
                                <p class="activity-text"><strong>Emily White</strong> completed onboarding</p>
                                <span class="activity-time">2 hours ago</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-avatar" style="background: linear-gradient(135deg, var(--warning), var(--gold));">RB</div>
                            <div class="activity-content">
                                <p class="activity-text"><strong>Robert Brown</strong> requested refund</p>
                                <span class="activity-time">3 hours ago</span>
                            </div>
                        </div>
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