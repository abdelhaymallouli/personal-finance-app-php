<?php
session_start();
require_once __DIR__ . '/../includes/user.php';
require __DIR__ . '/../includes/transactions.php';


if (!isset($_SESSION['user_id'])) {
    header('location: index.php');
    exit;
}

$errors = [];


$sql = "SELECT * FROM categories ORDER BY nom";
$stmt = $connection->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $montant = $_POST['montant'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $description = $_POST['description'] ?? '';
    $date_transaction = $_POST['date_transaction'] ?? date('Y-m-d');
    $user_id = $_SESSION['user_id'];

    if (empty($montant) || !is_numeric($montant)) {
        $errors[] = "Montant Invalide";
    }

    if (empty($category_id)) {
        $errors[] = "Please select a category.";
    }

    if (empty($date_transaction)) {
        $errors[] = "Please choose a date.";
    }

    if (empty($errors)) {
        if (addTransaction($connection, $user_id, $category_id, $montant, $description, $date_transaction)) {
            echo "<script>
                window.parent.postMessage('closeModal', '*');
            </script>";
            exit;
        } else {
            $errors[] = "Échec de l'ajout de la transaction.";
        }
    }
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
<form method="POST" action="">
    <label>Type :</label>
    <select name="type" required>
        <option value="revenu" <?= ($_POST['type'] ?? '') === 'revenu' ? 'selected' : '' ?>>Revenu</option>
        <option value="depense" <?= ($_POST['type'] ?? '') === 'depense' ? 'selected' : '' ?>>Dépense</option>
    </select><br>

    <label>Montant :</label>
    <input type="number" name="montant" step="0.01" required value="<?= htmlspecialchars($_POST['montant'] ?? '') ?>"><br>

    <label>Catégorie :</label>
    <select name="category_id" required>
    <option value="">-- Sélectionner --</option>
    <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat['id'] ?>" 
            <?= ($_POST['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['nom']) ?> (<?= $cat['type'] ?>)
        </option>
    <?php endforeach; ?>
</select>

    <label>Description :</label>
    <input type="text" name="description" value="<?= htmlspecialchars($_POST['description'] ?? '') ?>"><br>

    <label>Date :</label>
    <input type="date" name="date_transaction" value="<?= htmlspecialchars($_POST['date_transaction'] ?? date('Y-m-d')) ?>"><br>

    <button type="submit">Ajouter</button>
</form>

</body>
</html>