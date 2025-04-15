<?php

require_once __DIR__ . '/../config/config.php';

function cleanInput($data){
    return htmlspecialchars(stripslashes(trim($data)));
}

function addUser($user, $connection) {
    $name = cleanInput($user['name']);
    $email = cleanInput($user['email']);
    $rawPassword = cleanInput($user['password']);
    $password = password_hash($rawPassword, PASSWORD_DEFAULT);

    // Check if email already exists
    $stmt = $connection->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if($stmt->rowCount() > 0){
        return "Email already registered";
    }

    $stmt = $connection->prepare("INSERT INTO users (nom, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $password]);

    return "User added successfully";
}

function login($email, $password, $connection) {
    $stmt = $connection->prepare("SELECT id, nom, password FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }

    return false;
}


?>
