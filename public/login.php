<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ ."/../includes/user.php";

$message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];


    if(empty($email) || empty($password)){
        $message = "All fields are required.";
    }else {
        $user = login($email, $password, $connection);

        if($user){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nom'];
            header('location: daschboard.php');
            exit;
        }else {
            $message = "email ou mot de passe incorrect";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
    <h2>Se connecter</h2>
    <form method="POST" action="">
        <label>Email:</label><br>
        <input type="email" name="email"><br><br>
        <label>Mot de passe:</label><br>
        <input type="password" name="password"><br><br>
        <button type="submit">Connexion</button>
    </form>
    <p style="color:red;"><?= $message ?></p>
    <p>GO back to <a href="./register.php">Sign-up</a></p>
</body>
</html>