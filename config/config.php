<?php
// Database configuration
$host = 'localhost';
$dbname = 'gestion_budget';
$user = 'root'; // change this if your DB user is different
$password = ''; // change this if your DB password is not empty

try {
    // Create a new PDO connection
    $connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    
    // Set error mode to exception for better error handling
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Display error if connection fails
    die("Database connection failed: " . $e->getMessage());
}
?>
