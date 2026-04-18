<?php
session_start();
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Please fill in both email and password.";
        header("Location: login.php");
        exit();
    }
    
    try {
        $query = "SELECT id, name, email, password FROM admins WHERE email = :email LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $admin = $stmt->fetch();
            
            // Verify password hash
            if (password_verify($password, $admin['password'])) {
                // Success
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['admin_email'] = $admin['email'];
                
                header("Location: dashboard.php");
                exit();
            } else {
                $_SESSION['error'] = "Invalid credentials. Please try again.";
            }
        } else {
            $_SESSION['error'] = "Invalid credentials. Please try again.";
        }
    } catch(PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    }
    
    header("Location: login.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>
