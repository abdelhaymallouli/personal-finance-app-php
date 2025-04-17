<?php

require_once __DIR__ . '/../config/config.php';

function addUser($nom, $email, $password, $connection) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (nom, email, password) VALUES (:nom, :email, :password)";
    $stmt = $connection->prepare($query);
    return $stmt->execute([
        ':nom' => $nom,
        ':email' => $email,
        ':password' => $hashedPassword
    ]);
}


function checkUser($email, $connection) {
    $query = "SELECT id FROM users WHERE email = :email";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function login($email, $password, $connection) {
    $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }

    return false;
}


?>
