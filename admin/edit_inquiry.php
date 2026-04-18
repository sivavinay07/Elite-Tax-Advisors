<?php
include_once '../includes/admin_header.php';
require_once '../config/database.php';

if(!isset($_GET['id']) || empty(trim($_GET['id']))) {
    echo "<script>window.location='inquiries.php';</script>";
    exit();
}

$id = trim($_GET['id']);

// Update Logic
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = $_POST['status'];
    
    try {
        $stmt = $conn->prepare("UPDATE inquiries SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        
        if($stmt->execute()) {
            $_SESSION['success'] = "Synchronization complete. Lead status updated to: {$status}.";
            echo "<script>window.location='edit_inquiry.php?id=".$id."';</script>";
            exit();
        }
    } catch(PDOException $e) {
        $_SESSION['error'] = "System Conflict: " . $e->getMessage();
    }
}

// Fetch Inquiry
try {
    $stmt = $conn->prepare("SELECT * FROM inquiries WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    if($stmt->rowCount() == 0) {
        echo "<script>window.location='inquiries.php';</script>";
        exit();
    }
    
    $inquiry = $stmt->fetch();
} catch(PDOException $e) {
    die("Hardware/Database Error: " . $e->getMessage());
}
?>

<div class="fade-in">
    <div style="margin-bottom: 3.5rem; display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <a href="inquiries.php" class="btn-outline" style="width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border-color: var(--border); color: var(--text-muted); background: white;"><i class="fas fa-arrow-left"></i></a>
            <div>
                <h2 style="font-size: 2.3rem; letter-spacing: -1px;">Client Dossier</h2>
                <p style="color: var(--text-muted);">Inquiry Reference: <strong style="color: var(--secondary); font-family: monospace;">#TAX-<?php echo str_pad($id, 5, '0', STR_PAD_LEFT); ?></strong></p>
            </div>
        </div>
        <div class="badge <?php echo 'badge-'.strtolower($inquiry['status']); ?>" style="padding: 0.75rem 1.5rem; font-size: 0.8rem;">
            Current Phase: <?php echo $inquiry['status']; ?>
        </div>
    </div>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success fade-in"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-error fade-in"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 3.5rem;">
        <!-- Data Matrix -->
        <div class="glass-card shadow-xl" style="padding: 4rem; border-radius: var(--radius-xl);">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-bottom: 4rem;">
                <div>
                    <label style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 2px;">Legal Identity</label>
                    <div style="font-weight: 800; font-size: 1.5rem; color: var(--secondary); margin-top: 0.5rem;"><?php echo htmlspecialchars($inquiry['full_name']); ?></div>
                </div>
                <div>
                    <label style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 2px;">Email Endpoint</label>
                    <div style="font-size: 1.1rem; margin-top: 0.5rem;"><a href="mailto:<?php echo htmlspecialchars($inquiry['email']); ?>" style="color: var(--primary); font-weight: 700;"><?php echo htmlspecialchars($inquiry['email']); ?></a></div>
                </div>
                <div>
                    <label style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 2px;">Mobile Channel</label>
                    <div style="font-size: 1.1rem; margin-top: 0.5rem;"><a href="tel:<?php echo htmlspecialchars($inquiry['mobile']); ?>" style="color: var(--primary); font-weight: 700;"><?php echo htmlspecialchars($inquiry['mobile']); ?></a></div>
                </div>
                <div>
                    <label style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 2px;">Required Service</label>
                    <div style="font-weight: 800; color: var(--secondary); margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-briefcase" style="color: var(--primary); opacity: 0.6;"></i>
                        <?php echo htmlspecialchars($inquiry['service']); ?>
                    </div>
                </div>
            </div>

            <div style="border-top: 1.5px solid var(--border); padding-top: 3rem;">
                <label style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 2px;">Strategic Message</label>
                <div style="background: hsl(210, 40%, 97%); padding: 2.5rem; border-radius: var(--radius-lg); border: 1.5px solid var(--border); margin-top: 1rem; font-size: 1.1rem; line-height: 1.8; color: var(--text-main); position: relative; font-style: italic;">
                    <i class="fas fa-quote-left" style="position: absolute; top: 1rem; left: 1rem; opacity: 0.05; font-size: 3rem;"></i>
                    <?php echo htmlspecialchars($inquiry['message']); ?>
                </div>
            </div>
            
            <div style="margin-top: 3rem; font-size: 0.8rem; color: var(--text-muted);">
                Data synchronized on: <strong><?php echo date('F d, Y @ h:i A', strtotime($inquiry['created_at'])); ?></strong> from origin: <strong><?php echo htmlspecialchars($inquiry['city']) ?: 'Remote IP'; ?></strong>
            </div>
        </div>

        <!-- System Ops -->
        <div>
            <div class="glass-card shadow-lg" style="padding: 3rem; border-top: 6px solid var(--primary);">
                <h3 style="font-size: 1.4rem; margin-bottom: 2rem; color: var(--secondary); display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-terminal" style="color: var(--primary);"></i> Operations
                </h3>
                
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="status" style="opacity: 0.6;">Workflow Status</label>
                        <select name="status" id="status" class="form-control" style="font-weight: 800; padding: 1rem;">
                            <option value="New" <?php echo $inquiry['status'] == 'New' ? 'selected' : ''; ?>>New Opportunity</option>
                            <option value="Contacted" <?php echo $inquiry['status'] == 'Contacted' ? 'selected' : ''; ?>>Discussion Active</option>
                            <option value="Closed" <?php echo $inquiry['status'] == 'Closed' ? 'selected' : ''; ?>>Files Closed</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1.25rem; font-size: 1rem; margin-top: 2rem;">
                        Commit Synchronize <i class="fas fa-sync" style="margin-left: 0.75rem;"></i>
                    </button>
                </form>
            </div>
            
            <div style="margin-top: 2rem; border: 1px dashed var(--danger); padding: 2rem; border-radius: var(--radius-lg); text-align: center; opacity: 0.7; transition: var(--transition);" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.7'">
                <h4 style="color: var(--danger); font-size: 0.9rem; margin-bottom: 1rem;">Destructive Action</h4>
                <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 1.5rem;">Permanently remove this client data from the ecosystem.</p>
                <a href="delete_inquiry.php?id=<?php echo $row['id']; ?>" class="btn" style="background: #fef2f2; color: var(--danger); font-size: 0.8rem; border: 1px solid #fee2e2; width: 100%; justify-content: center;" onclick="return confirm('WARNING: Permanent archiving of this dossier?');">
                    Archive Client Data
                </a>
            </div>
        </div>
    </div>
</div>

<?php include_once '../includes/admin_footer.php'; ?>
