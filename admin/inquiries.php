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

<div class="fade-in">
    <div style="margin-bottom: 3rem; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h2 style="font-size: 2.3rem; margin-bottom: 0.5rem; letter-spacing: -1px;">Lead Ledger</h2>
            <p style="color: var(--text-muted);">A consolidated audit trail of all consultancy capture points.</p>
        </div>
    </div>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success fade-in"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-error fade-in"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="table-container shadow-xl">
        <div style="padding: 2rem; border-bottom: 1.5px solid var(--border); background: #fefefe;">
            <form method="GET" action="inquiries.php" style="display: flex; gap: 1.5rem; flex-wrap: wrap; align-items: center;">
                <div style="flex-grow: 1; min-width: 300px; position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 1.25rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); opacity: 0.5;"></i>
                    <input type="text" name="search" class="form-control" style="padding-left: 3rem;" placeholder="Search client records (name, email)..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div style="min-width: 200px;">
                    <select name="status" class="form-control">
                        <option value="">All Workflow Phases</option>
                        <option value="New" <?php echo $status_filter == 'New' ? 'selected' : ''; ?>>New Leads</option>
                        <option value="Contacted" <?php echo $status_filter == 'Contacted' ? 'selected' : ''; ?>>In Discussion</option>
                        <option value="Closed" <?php echo $status_filter == 'Closed' ? 'selected' : ''; ?>>Closed Files</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="padding: 0.85rem 2rem; font-size: 0.9rem;">
                    Sync Filter <i class="fas fa-filter" style="margin-left: 0.5rem;"></i>
                </button>
                <?php if(!empty($search) || !empty($status_filter)): ?>
                    <a href="inquiries.php" style="color: var(--text-muted); font-size: 0.85rem; font-weight: 700;">Reset</a>
                <?php endif; ?>
            </form>
        </div>
        
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th style="padding-left: 3rem;">Timestamp</th>
                        <th>Client Profile</th>
                        <th>Interest</th>
                        <th>Phase</th>
                        <th style="text-align: center; padding-right: 3rem;">Terminal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($error)): ?>
                        <tr><td colspan="5" style="color:var(--danger); text-align: center; padding: 4rem;"><?php echo $error; ?></td></tr>
                    <?php elseif(count($inquiries) > 0): ?>
                        <?php foreach($inquiries as $row): 
                            $date = date('M d, Y', strtotime($row['created_at']));
                            $time = date('h:i A', strtotime($row['created_at']));
                            $status_class = 'badge-' . strtolower($row['status']);
                        ?>
                            <tr style="transition: var(--transition);">
                                <td style="padding-left: 3rem;">
                                    <div style="font-weight: 700; color: var(--secondary); font-size: 0.95rem;"><?php echo $date; ?></div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted);"><?php echo $time; ?></div>
                                </td>
                                <td>
                                    <div style="font-weight: 800; color: var(--secondary); display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="width: 32px; height: 32px; background: var(--bg-main); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: var(--primary); border: 1px solid var(--border);">
                                            <?php echo strtoupper(substr($row['full_name'], 0, 1)); ?>
                                        </div>
                                        <?php echo htmlspecialchars($row['full_name']); ?>
                                    </div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.4rem; padding-left: 2.75rem;">
                                        <?php echo htmlspecialchars($row['email']); ?>
                                    </div>
                                </td>
                                <td><span style="font-weight: 600; color: var(--secondary); font-size: 0.9rem;"><?php echo htmlspecialchars($row['service']); ?></span></td>
                                <td><span class="badge <?php echo $status_class; ?>" style="padding: 0.5rem 1.25rem; font-size: 0.7rem;"><i class="fas fa-circle" style="font-size: 0.4rem; margin-right: 0.4rem;"></i> <?php echo htmlspecialchars($row['status']); ?></span></td>
                                <td style="padding-right: 3rem;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                        <a href="edit_inquiry.php?id=<?php echo $row['id']; ?>" class="btn-outline" style="padding: 0.6rem; border-color: var(--border); background: white; color: var(--text-muted); border-radius: var(--radius-sm);" title="Edit"><i class="fas fa-pen-nib"></i></a>
                                        <a href="delete_inquiry.php?id=<?php echo $row['id']; ?>" style="padding: 0.6rem; color: #fca5a5; display: flex; align-items: center;" title="Archive" onclick="return confirm('Execute permanent archive for this lead?');"><i class="fas fa-trash-can"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align: center; padding: 6rem; color: var(--text-muted);"><i class="fas fa-folder-open" style="font-size: 3rem; opacity: 0.1; display: block; margin-bottom: 1rem;"></i> No records currently synchronize with these parameters.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once '../includes/admin_footer.php'; ?>
