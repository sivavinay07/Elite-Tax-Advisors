<?php
session_start();
require_once 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $full_name = htmlspecialchars(strip_tags(trim($_POST['full_name'])));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $mobile = htmlspecialchars(strip_tags(trim($_POST['mobile'])));
    $city = htmlspecialchars(strip_tags(trim($_POST['city'])));
    $service = htmlspecialchars(strip_tags(trim($_POST['service'])));
    $message = htmlspecialchars(strip_tags(trim($_POST['message'])));

    // Basic validation
    if (empty($full_name) || empty($email) || empty($mobile) || empty($service) || empty($message)) {
        $_SESSION['error'] = "Please fill in all required fields.";
        header("Location: contact.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: contact.php");
        exit();
    }

    // Database Insertion 
    try {
        $query = "INSERT INTO inquiries (full_name, email, mobile, city, service, message) 
                  VALUES (:full_name, :email, :mobile, :city, :service, :message)";

        $stmt = $conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':service', $service);
        $stmt->bindParam(':message', $message);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Thank you! Your inquiry has been submitted successfully. We will get back to you shortly.";
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again later.";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    }

    header("Location: contact.php");
    exit();
} else {
    header("Location: contact.php");
    exit();
}
?>