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
        if (array_key_exists($key, $stats)) {
            $stats[$key] = $row['count'];
        }
    }
} catch(PDOException $e) {
    echo "<div class='alert alert-error fade-in'>Connection Error: " . $e->getMessage() . "</div>";
}
?>

<div class="fade-in">
    <div style="margin-bottom: 3rem;">
        <h2 style="font-size: 2rem; margin-bottom: 0.5rem;">Global Overview</h2>
        <p style="color: var(--text-muted);">Real-time metrics for your consultancy pipeline.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card" style="position: relative; overflow: hidden;">
            <div style="position: absolute; top:0; right:0; padding: 1.5rem; opacity: 0.1; font-size: 4rem;"><i class="fas fa-users"></i></div>
            <h4>Total Volume</h4>
            <div class="value"><?php echo $stats['total']; ?></div>
            <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700;">Total inquiries processed</div>
        </div>
        
        <div class="stat-card" style="position: relative; overflow: hidden; border-top: 4px solid var(--primary);">
            <div style="position: absolute; top:0; right:0; padding: 1.5rem; opacity: 0.1; font-size: 4rem; color: var(--primary);"><i class="fas fa-sparkles"></i></div>
            <h4>New Opportunities</h4>
            <div class="value" style="color: var(--primary);"><?php echo $stats['new']; ?></div>
            <div style="font-size: 0.75rem; color: var(--primary); font-weight: 700;">Awaiting first contact</div>
        </div>
        
        <div class="stat-card" style="position: relative; overflow: hidden; border-top: 4px solid #f59e0b;">
            <div style="position: absolute; top:0; right:0; padding: 1.5rem; opacity: 0.1; font-size: 4rem; color: #f59e0b;"><i class="fas fa-comments"></i></div>
            <h4>In Discussion</h4>
            <div class="value" style="color: #d97706;"><?php echo $stats['contacted']; ?></div>
            <div style="font-size: 0.75rem; color: #d97706; font-weight: 700;">Leads being nurtured</div>
        </div>
        
        <div class="stat-card" style="position: relative; overflow: hidden; border-top: 4px solid #10b981;">
            <div style="position: absolute; top:0; right:0; padding: 1.5rem; opacity: 0.1; font-size: 4rem; color: #10b981;"><i class="fas fa-check-double"></i></div>
            <h4>Fulfilled</h4>
            <div class="value" style="color: #059669;"><?php echo $stats['closed']; ?></div>
            <div style="font-size: 0.75rem; color: #059669; font-weight: 700;">Successfully converted</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr; gap: 3rem; margin-top: 3rem;">
        <!-- Recent Table -->
        <div class="table-container shadow-xl">
            <div style="padding: 2rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.25rem;">Latest Client Interactions</h3>
                <a href="inquiries.php" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.8rem;">View Entire Ledger</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th style="padding-left: 3rem;">Recipient</th>
                        <th>Interest</th>
                        <th>Phase</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $stmt = $conn->query("SELECT id, full_name, service, status, created_at FROM inquiries ORDER BY created_at DESC LIMIT 8");
                        if($stmt->rowCount() > 0) {
                            while($row = $stmt->fetch()) {
                                $status_class = 'badge-' . strtolower($row['status']);
                                echo "<tr>
                                    <td style='padding-left: 3rem;'>
                                        <div style='font-weight: 700; color: var(--secondary);'>{$row['full_name']}</div>
                                        <div style='font-size: 0.75rem; color: var(--text-muted);'>".date('M d, H:i', strtotime($row['created_at']))."</div>
                                    </td>
                                    <td style='font-size: 0.85rem;'>{$row['service']}</td>
                                    <td><span class='badge {$status_class}'>{$row['status']}</span></td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' style='text-align:center; padding: 4rem; color: var(--text-muted);'>System: No records found.</td></tr>";
                        }
                    } catch(PDOException $e) {
                        echo "<tr><td colspan='3'>Internal Table Error.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once '../includes/admin_footer.php'; ?>
