<?php

$host = 'localhost';
$dbname = 'gestion_budget';
$user = 'root'; 
$password = ''; 
try {
    $connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
