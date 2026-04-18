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
    <title>Admin Dashboard - Elite Tax Advisors</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <a href="dashboard.php" class="logo">ETA Admin</a>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="inquiries.php" class="<?php echo ($current_page == 'inquiries.php' || $current_page == 'edit_inquiry.php') ? 'active' : ''; ?>">
                    <i class="fas fa-envelope"></i> Inquiries
                </a>
            </nav>
            <div class="sidebar-footer">
                <div style="font-size: 0.8rem; color: #cbd5e1; margin-bottom: 0.5rem;">
                    Logged in as <br><strong style="color: white;"><?php echo htmlspecialchars($_SESSION['admin_name']); ?></strong>
                </div>
                <a href="logout.php" style="color: #fca5a5; text-decoration: none; font-size: 0.875rem;"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </aside>
        
        <main class="main-content">
