<?php
session_start();
require_once '../config/config.php';
require_once '../includes/transactions.php';

if(!isset($_SESSION['user_id'])) {
    header('location: index.php');
    exit;
}

if(!isset($_GET['id'])) {
    echo 'Transaction ID is required.';
    exit();
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'];

$stmt = $connection->prepare("SELECT * FROM transactions WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $user_id]);
$transaction = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$transaction) {
    echo 'Transaction not found.';
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $category_id = $_POST['category_id'];
    $montant = $_POST['montant'];
    $description = $_POST['description'];
    $date_transaction = $_POST['date_transaction'];

    if (updateTransaction($connection, $id, $user_id, $category_id, $montant, $description, $date_transaction)) {
        header('Location: dashboard.php?success=Transaction updated successfully.');
        exit();
    } else {
        echo 'Failed to update transaction.';
    }
}

$cat_stmt = $connection->prepare("SELECT * FROM categories");
$cat_stmt->execute();
$categories = $cat_stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<h2>Modifier une transaction</h2>
<form method="post">
    <label>Catégorie :</label>
    <select name="category_id" required>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $transaction['category_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['nom']) ?> (<?= htmlspecialchars($cat['type']) ?>)
            </option>
        <?php endforeach; ?>
    </select><br>

    <label>Montant :</label>
    <input type="number" step="0.01" name="montant" value="<?= $transaction['montant'] ?>" required><br>

    <label>Description :</label>
    <input type="text" name="description" value="<?= htmlspecialchars($transaction['description']) ?>"><br>

    <label>Date :</label>
    <input type="date" name="date_transaction" value="<?= $transaction['date_transaction'] ?>" required><br>

    <button type="submit">Enregistrer</button>
</form>