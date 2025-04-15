<?php

require_once __DIR__ . '/../includes/user.php';


$message = '';


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $user = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
    ];

    // Validation
    if (empty($user['name']) || empty($user['email']) || empty($user['password'])) {
        $message = "All fields are required.";
    } else {
        $result = addUser($user, $connection);
        if ($result === true) {
            header('Location: login.php');
            exit; // Stop execution after redirect
        } else {
            $message = $result; // error message
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>

    <h2>Créer un compte</h2>
    <form method="POST" action="">
        <label>Nom:</label><br>
        <input type="text" name="name"><br><br>
        <label>Email:</label><br>
        <input type="email" name="email"><br><br>
        <label>Mot de passe:</label><br>
        <input type="password" name="password"><br><br>
        <button type="submit">S'inscrire</button>
    </form>
    <p style="color:red;"><?= $message ?></p>
    <a href="./login.php">login</a>
</body>
</html>