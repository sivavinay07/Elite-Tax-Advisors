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
    <title>Secure Access | Elite Tax Advisors Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="min-height: 100vh; overflow: hidden; background: #0f172a;">
    
    <!-- Cinematic Background -->
    <div style="position: fixed; top:0; left:0; width:100%; height:100%; z-index:-1; opacity: 0.6;">
        <img src="../assets/images/hero-bg.png" alt="" style="width:100%; height:100%; object-fit:cover; filter: blur(4px) grayscale(0.5);">
        <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: linear-gradient(to bottom right, hsla(243, 75%, 20%, 0.9), hsla(263, 70%, 10%, 0.95));"></div>
    </div>

    <div class="auth-layout" style="background: transparent; display: flex; justify-content: center; align-items: center; padding: 4rem 1rem;">
        <div class="fade-in" style="width: 100%; max-width: 440px; margin-top: -2rem;">
            <div style="text-align: center; margin-bottom: 3.5rem;">
                <div style="font-size: 2.8rem; color: #fff; font-weight: 800; letter-spacing: -2px; margin-bottom: 0.75rem;">
                    <i class="fas fa-landmark" style="color: var(--primary-light);"></i> ETA Admin
                </div>
                <p style="color: rgba(255,255,255,0.6); font-weight: 500;">Authorized Management Access Only</p>
            </div>

            <div class="form-card" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,1); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); padding: 3rem; border-radius: var(--radius-xl);">
                <div style="margin-bottom: 2.5rem; text-align: center;">
                    <h2 style="color: var(--secondary); font-size: 1.5rem; margin-bottom: 0.5rem;">Secure Sign In</h2>
                    <p style="color: var(--text-muted); font-size: 0.85rem;">Please enter your credentials to synchronize.</p>
                </div>
                
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>

                <?php if(isset($_SESSION['success'])): ?>
                    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
                <?php endif; ?>

                <form action="authenticate.php" method="POST">
                    <div class="form-group">
                        <label for="email" style="color: var(--secondary);">System Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" required placeholder="admin@domain.com">
                    </div>
                    <div class="form-group">
                        <label for="password" style="color: var(--secondary);">Access Key</label>
                        <input type="password" id="password" name="password" class="form-control" required placeholder="••••••••">
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1.1rem; margin-top: 1rem;">
                        Authorize Connection <i class="fas fa-key"></i>
                    </button>
                    
                    <div style="text-align: center; margin-top: 2rem;">
                        <a href="../index.php" style="color: rgba(255,255,255,0.4); font-size: 0.85rem; font-weight: 600;">
                            <i class="fas fa-arrow-left"></i> Return to Public Site
                        </a>
                    </div>
                </form>
            </div>
            
            <div style="text-align: center; margin-top: 3rem; color: rgba(255,255,255,0.2); font-size: 0.75rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;">
                Elite Tax Advisors &copy; 2026
            </div>
        </div>
    </div>
</body>
</html>
