<?php
session_start();
if(isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Elite Tax Advisors</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="auth-layout">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Admin Login</h2>
                <p>Sign in to manage inquiries</p>
            </div>
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <form action="authenticate.php" method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required placeholder="admin@example.com">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="••••••••">
                </div>
                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn-primary" style="width: 100%;">Sign In</button>
                    <div style="text-align: center; margin-top: 1rem;">
                        <a href="../index.php" style="color: var(--text-secondary); font-size: 0.875rem;">&larr; Back to Website</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
