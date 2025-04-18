<?php

$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History - Enfix</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>">
    <style>

        
        /* Sidebar */
        .sidebar {
            width: 86px;
            height: 100vh;
            position: fixed;
            background-color: var(--sidebar-blue);
            display: flex;

            flex-direction: column;
            align-items: center;
            padding: 20px 0;
        }
        
        .sidebar-logo {
            margin-bottom: 30px;
        }
        
        .sidebar-nav {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-grow: 1;
            gap: 25px;
        }
        
        .sidebar-nav a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
        
        .sidebar-nav a:hover, .sidebar-nav a.active {
            opacity: 1;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        /* Main Content */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        /* Header */
        .header {
            display: flex;
            justify-content: space-between; /* Ensures the content is spread across the header */
            align-items: center;
            padding: 20px 30px;
            border-bottom: 1px solid var(--border-color);
        }
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-left: auto; 
        }
                
        .theme-toggle, .notifications, .user-profile {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: transparent;
            color: var(--text-light);
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .theme-toggle:hover, .notifications:hover {
            background-color: var(--input-bg);
        }
        
        .user-profile {
            background-color: var(--light-blue);
        }
        
        /* Navigation */
        .main-nav {
            padding: 0 30px;
            margin: 15px 0;
        }
        
        .main-nav ul {
            list-style: none;
            display: flex;
            gap: 25px;
        }
        
        .main-nav a {
            color: var(--text-gray);
            text-decoration: none;
            padding: 5px 0;
            transition: color 0.2s;
            font-weight: 500;
        }
        
        .main-nav a:hover, .main-nav a.active {
            color: var(--text-light);
        }
        
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
    <div class="sidebar-logo">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="white">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
        </svg>
    </div>
    <div class="sidebar-nav">
        <a href="dashboard.php" title="Dashboard" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
            <i class="fas fa-chart-pie"></i>
        </a>
        <a href="transactions.php" title="Transaction" class="<?php echo basename($_SERVER['PHP_SELF']) == 'transactions.php' ? 'active' : ''; ?>">
            <i class="fas fa-chart-line"></i>
        </a>
        <a href="#" title="Users" class=""><i class="fas fa-user"></i></a>
    </div>
    <div class="sidebar-bottom">
        <a href="#" title="Settings"><i class="fas fa-cog"></i></a>
    </div>
</div>




    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">

            <div class="header-right">

                <div class="user-profile">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>
        <!-- Navigation -->
        <nav class="main-nav">
    <ul>
        <li><a href="dashboard.php" class="<?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">dashboard</a></li>
        <li><a href="transactions.php" class="<?php echo ($currentPage == 'transactions.php') ? 'active' : ''; ?>">Transaction History</a></li>
    </ul>
</nav>

    </body>
    </html>