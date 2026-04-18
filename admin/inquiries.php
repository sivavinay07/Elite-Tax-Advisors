<?php
include_once '../includes/admin_header.php';
require_once '../config/database.php';

// Search & Filter Logic
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? trim($_GET['status']) : '';

$query = "SELECT * FROM inquiries WHERE 1=1";
$params = [];

if(!empty($search)) {
    $query .= " AND (full_name LIKE :search OR email LIKE :search OR mobile LIKE :search)";
    $params[':search'] = "%{$search}%";
}

if(!empty($status_filter)) {
    $query .= " AND status = :status";
    $params[':status'] = $status_filter;
}

$query .= " ORDER BY created_at DESC";

try {
    $stmt = $conn->prepare($query);
    foreach($params as $key => &$val) {
        $stmt->bindParam($key, $val);
    }
    $stmt->execute();
    $inquiries = $stmt->fetchAll();
} catch(PDOException $e) {
    $error = "Database Error: " . $e->getMessage();
}
?>

<div class="page-header">
    <h1 class="page-title">Manage Inquiries</h1>
</div>

<?php if(isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if(isset($_SESSION['error'])): ?>
    <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<div class="table-container">
    <div class="table-header">
        <form method="GET" action="inquiries.php">
            <input type="text" name="search" class="form-control" placeholder="Search name, email, or mobile..." value="<?php echo htmlspecialchars($search); ?>">
            <select name="status" class="form-control" style="max-width: 200px;">
                <option value="">All Statuses</option>
                <option value="New" <?php echo $status_filter == 'New' ? 'selected' : ''; ?>>New</option>
                <option value="Contacted" <?php echo $status_filter == 'Contacted' ? 'selected' : ''; ?>>Contacted</option>
                <option value="Closed" <?php echo $status_filter == 'Closed' ? 'selected' : ''; ?>>Closed</option>
            </select>
            <button type="submit" class="btn-primary" style="padding: 0.5rem 1.5rem;">Filter</button>
            <?php if(!empty($search) || !empty($status_filter)): ?>
                <a href="inquiries.php" class="btn-outline" style="padding: 0.5rem 1rem; border-radius: 8px;">Clear</a>
            <?php endif; ?>
        </form>
    </div>
    
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Details</th>
                    <th>Service</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($error)): ?>
                    <tr><td colspan="5" style="color:red;"><?php echo $error; ?></td></tr>
                <?php elseif(count($inquiries) > 0): ?>
                    <?php foreach($inquiries as $row): 
                        $date = date('M d, Y h:i A', strtotime($row['created_at']));
                        $status_class = 'status-' . $row['status'];
                    ?>
                        <tr>
                            <td style="white-space: nowrap;"><?php echo $date; ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($row['full_name']); ?></strong><br>
                                <span style="font-size: 0.8rem; color: var(--text-secondary);">
                                    <?php echo htmlspecialchars($row['email']); ?><br>
                                    <?php echo htmlspecialchars($row['mobile']); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($row['service']); ?></td>
                            <td><span class="badge <?php echo $status_class; ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                            <td>
                                <div class="actions">
                                    <a href="edit_inquiry.php?id=<?php echo $row['id']; ?>" class="btn-outline btn-sm" title="Edit/View"><i class="fas fa-edit"></i></a>
                                    <a href="delete_inquiry.php?id=<?php echo $row['id']; ?>" class="btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this inquiry?');"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align: center; padding: 2rem;">No inquiries found matching your criteria.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once '../includes/admin_footer.php'; ?>
