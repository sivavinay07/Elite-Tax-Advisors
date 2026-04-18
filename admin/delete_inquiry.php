<?php
session_start();
require_once '../config/database.php';

// Auth check
if(!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if(isset($_GET['id']) && !empty(trim($_GET['id']))) {
    $id = trim($_GET['id']);
    
    try {
        $stmt = $conn->prepare("DELETE FROM inquiries WHERE id = :id");
        $stmt->bindParam(':id', $id);
        
        if($stmt->execute()) {
            $_SESSION['success'] = "Inquiry deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete inquiry.";
        }
    } catch(PDOException $e) {
        $_SESSION['error'] = "Database Error: " . $e->getMessage();
    }
}

header("Location: inquiries.php");
exit();
?>
