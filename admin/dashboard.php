<?php
include_once '../includes/admin_header.php';
require_once '../config/database.php';

// Get statistics
$stats = [
    'total' => 0,
    'new' => 0,
    'contacted' => 0,
    'closed' => 0
];

try {
    // Total Inquiries
    $stmt = $conn->query("SELECT COUNT(*) as count FROM inquiries");
    $stats['total'] = $stmt->fetch()['count'];

    // Status Counts
    $stmt = $conn->query("SELECT status, COUNT(*) as count FROM inquiries GROUP BY status");
    while($row = $stmt->fetch()) {
        $key = strtolower($row['status']);
        $stats[$key] = $row['count'];
    }
} catch(PDOException $e) {
    echo "<div class='alert alert-error'>Database Error: " . $e->getMessage() . "</div>";
}
?>

<div class="page-header">
    <h1 class="page-title">Dashboard Overview</h1>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h4>Total Inquiries</h4>
        <div class="value"><?php echo $stats['total']; ?></div>
    </div>
    
    <div class="stat-card new">
        <h4>New</h4>
        <div class="value"><?php echo $stats['new']; ?></div>
    </div>
    
    <div class="stat-card contacted">
        <h4>Contacted</h4>
        <div class="value"><?php echo $stats['contacted']; ?></div>
    </div>
    
    <div class="stat-card closed">
        <h4>Closed</h4>
        <div class="value"><?php echo $stats['closed']; ?></div>
    </div>
</div>

<div class="table-container" style="margin-top: 2rem;">
    <div class="table-header">
        <h3 style="color: var(--secondary); font-size: 1.125rem;">Recent Inquiries</h3>
        <a href="inquiries.php" class="btn-outline btn-sm">View All &rarr;</a>
    </div>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Service</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $stmt = $conn->query("SELECT id, full_name, service, status, created_at FROM inquiries ORDER BY created_at DESC LIMIT 5");
                    
                    if($stmt->rowCount() > 0) {
                        while($row = $stmt->fetch()) {
                            $date = date('M d, Y', strtotime($row['created_at']));
                            $status_class = 'status-' . $row['status'];
                            echo "<tr>
                                <td>{$date}</td>
                                <td style='font-weight: 500;'>{$row['full_name']}</td>
                                <td>{$row['service']}</td>
                                <td><span class='badge {$status_class}'>{$row['status']}</span></td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align:center;'>No inquiries found.</td></tr>";
                    }
                } catch(PDOException $e) {
                    echo "<tr><td colspan='4'>Error loading data.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once '../includes/admin_footer.php'; ?>
