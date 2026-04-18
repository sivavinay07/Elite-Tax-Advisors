<?php
include_once '../includes/admin_header.php';
require_once '../config/database.php';

if(!isset($_GET['id']) || empty(trim($_GET['id']))) {
    header("Location: inquiries.php");
    exit();
}

$id = trim($_GET['id']);

// Update Logic
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = $_POST['status'];
    $notes = ""; // Could be expanded later
    
    try {
        $stmt = $conn->prepare("UPDATE inquiries SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        
        if($stmt->execute()) {
            $_SESSION['success'] = "Inquiry status updated successfully.";
            header("Location: edit_inquiry.php?id=" . $id);
            exit();
        }
    } catch(PDOException $e) {
        $_SESSION['error'] = "Database Error: " . $e->getMessage();
    }
}

// Fetch Inquiry
try {
    $stmt = $conn->prepare("SELECT * FROM inquiries WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    if($stmt->rowCount() == 0) {
        header("Location: inquiries.php");
        exit();
    }
    
    $inquiry = $stmt->fetch();
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<div class="page-header">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <a href="inquiries.php" class="btn-outline" style="padding: 0.5rem; border-radius: 50%;"><i class="fas fa-arrow-left"></i></a>
        <h1 class="page-title">View / Edit Inquiry</h1>
    </div>
</div>

<?php if(isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if(isset($_SESSION['error'])): ?>
    <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <!-- Details Card -->
    <div class="form-card" style="margin: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <h3 style="border-bottom: 1px solid var(--border-color); padding-bottom: 1rem; margin-bottom: 1.5rem; color: var(--secondary);">Client Information</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="color: var(--text-secondary); font-size: 0.8rem; text-transform: uppercase;">Full Name</label>
                <div style="font-weight: 500; font-size: 1.1rem;"><?php echo htmlspecialchars($inquiry['full_name']); ?></div>
            </div>
            <div>
                <label style="color: var(--text-secondary); font-size: 0.8rem; text-transform: uppercase;">Email Address</label>
                <div><a href="mailto:<?php echo htmlspecialchars($inquiry['email']); ?>" style="color: var(--primary);"><?php echo htmlspecialchars($inquiry['email']); ?></a></div>
            </div>
            <div>
                <label style="color: var(--text-secondary); font-size: 0.8rem; text-transform: uppercase;">Mobile Number</label>
                <div><a href="tel:<?php echo htmlspecialchars($inquiry['mobile']); ?>" style="color: var(--primary);"><?php echo htmlspecialchars($inquiry['mobile']); ?></a></div>
            </div>
            <div>
                <label style="color: var(--text-secondary); font-size: 0.8rem; text-transform: uppercase;">City</label>
                <div><?php echo htmlspecialchars($inquiry['city']) ?: 'N/A'; ?></div>
            </div>
            <div>
                <label style="color: var(--text-secondary); font-size: 0.8rem; text-transform: uppercase;">Service Requested</label>
                <div style="font-weight: 600;"><?php echo htmlspecialchars($inquiry['service']); ?></div>
            </div>
            <div>
                <label style="color: var(--text-secondary); font-size: 0.8rem; text-transform: uppercase;">Date Submitted</label>
                <div><?php echo date('F d, Y - h:i A', strtotime($inquiry['created_at'])); ?></div>
            </div>
        </div>
        
        <div>
            <label style="color: var(--text-secondary); font-size: 0.8rem; text-transform: uppercase;">Message / Requirements</label>
            <div style="background: var(--bg-main); padding: 1rem; border-radius: 8px; border: 1px solid var(--border-color); margin-top: 0.5rem; white-space: pre-wrap;"><?php echo htmlspecialchars($inquiry['message']); ?></div>
        </div>
    </div>
    
    <!-- Action Card -->
    <div class="form-card" style="margin: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); height: fit-content;">
        <h3 style="border-bottom: 1px solid var(--border-color); padding-bottom: 1rem; margin-bottom: 1.5rem; color: var(--secondary);">Update Status</h3>
        
        <form action="" method="POST">
            <div class="form-group">
                <label for="status">Current Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="New" <?php echo $inquiry['status'] == 'New' ? 'selected' : ''; ?>>New</option>
                    <option value="Contacted" <?php echo $inquiry['status'] == 'Contacted' ? 'selected' : ''; ?>>Contacted</option>
                    <option value="Closed" <?php echo $inquiry['status'] == 'Closed' ? 'selected' : ''; ?>>Closed</option>
                </select>
            </div>
            
            <button type="submit" class="btn-primary" style="width: 100%; margin-top: 1rem;">Save Changes</button>
        </form>
    </div>
</div>

<?php include_once '../includes/admin_footer.php'; ?>
