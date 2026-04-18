<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Get current page to highlight menu
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Console | Elite Tax Advisors</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Extra Admin Layout Specifics */
        .admin-sidebar {
            width: 280px;
            background: hsl(222, 47%, 7%);
            color: #fff;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1001;
            padding: 2.5rem 1.5rem;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255,255,255,0.05);
        }

        .admin-content {
            margin-left: 280px;
            min-height: 100vh;
            background: var(--bg-main);
            width: calc(100% - 280px);
        }

        .top-header {
            height: 80px;
            background: var(--bg-glass);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 3rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.25rem;
            border-radius: var(--radius-md);
            color: rgba(255,255,255,0.5);
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
            transition: var(--transition);
        }

        .sidebar-item:hover, .sidebar-item.active {
            color: #fff;
            background: rgba(255,255,255,0.05);
        }

        .sidebar-item.active {
            background: var(--primary);
            box-shadow: 0 10px 15px -5px hsla(243, 75%, 59%, 0.3);
        }

        .user-block {
            margin-top: auto;
            padding: 1.5rem;
            background: rgba(255,255,255,0.03);
            border-radius: var(--radius-lg);
            border: 1px solid rgba(255,255,255,0.05);
        }

        @media (max-width: 1024px) {
            .admin-sidebar { width: 80px; padding: 2rem 0.5rem; }
            .admin-content { margin-left: 80px; width: calc(100% - 80px); }
            .sidebar-item span, .admin-sidebar .logo span { display: none; }
            .sidebar-item { justify-content: center; padding: 1.25rem; }
            .user-block { display: none; }
        }
    </style>
</head>
<body style="background: var(--bg-main);">

    <div style="display: flex;">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="logo" style="margin-bottom: 3.5rem; color: #fff; justify-content: flex-start; padding-left: 0.5rem;">
                <i class="fas fa-landmark" style="color: var(--primary-light);"></i> <span>ETA Admin</span>
            </div>

            <nav>
                <a href="dashboard.php" class="sidebar-item <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
                    <i class="fas fa-chart-pie"></i> <span>Overview</span>
                </a>
                <a href="inquiries.php" class="sidebar-item <?php echo ($current_page == 'inquiries.php' || $current_page == 'edit_inquiry.php') ? 'active' : ''; ?>">
                    <i class="fas fa-envelopes-bulk"></i> <span>Lead Ledger</span>
                </a>
            </nav>

            <div class="user-block">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                    <div style="width: 40px; height: 40px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem;">
                        <?php echo strtoupper(substr($_SESSION['admin_name'], 0, 1)); ?>
                    </div>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 700;"><?php echo htmlspecialchars($_SESSION['admin_name']); ?></div>
                        <div style="font-size: 0.7rem; color: rgba(255,255,255,0.4);">Administrator</div>
                    </div>
                </div>
                <a href="logout.php" style="font-size: 0.8rem; color: #fca5a5; font-weight: 700;"><i class="fas fa-power-off"></i> Terminate Session</a>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="admin-content">
            <header class="top-header">
                <div style="font-weight: 700; color: var(--text-muted); font-size: 0.9rem;">
                    <i class="fas fa-shield-halved"></i> Management Workspace / <span style="color: var(--secondary);"><?php echo ($current_page == 'dashboard.php') ? 'Overview' : 'Lead Management'; ?></span>
                </div>
                
                <div style="display: flex; align-items: center; gap: 2rem;">
                    <div style="font-weight: 700; font-size: 0.85rem; color: var(--secondary);"><?php echo date('l, M d'); ?></div>
                </div>
            </header>
            
            <div style="padding: 3rem;">
