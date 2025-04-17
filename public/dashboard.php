<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?> !</h2>
<a href="logout.php">Déconnexion</a>
    
<a href="add_transaction.php"> add a transaction</a>
</body>
</html>



