<?php
// config/database.php
$host = 'localhost';
$db_name = 'ca_firm_db';
$username = 'root'; // default xampp
$password = ''; // default xampp

try {
    $conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name . ";charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $exception) {
    if(strpos($exception->getMessage(), 'Unknown database') !== false) {
        die("<strong>Database configuration error:</strong> The database '$db_name' does not exist. Please run the contents of <em>database.sql</em> in your MySQL server.");
    }
    die("<strong>Connection error:</strong> " . $exception->getMessage());
}
?>
