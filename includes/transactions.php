<?php 
function addTransaction($connection, $user_id, $category_id, $montant, $description, $date_transaction) {
    $stmt = $connection->prepare("
        INSERT INTO transactions (user_id, category_id, montant, description, date_transaction)
        VALUES (?, ?, ?, ?, ?)
    ");
    return $stmt->execute([$user_id, $category_id, $montant, $description, $date_transaction]);
}
function deleteTransaction($connection, $transaction_id, $user_id) {
    $stmt = $connection->prepare("DELETE FROM transactions WHERE id = ? AND user_id = ?");
    return $stmt->execute([$transaction_id, $user_id]);
}

function updateTransaction($connection, $id, $user_id, $category_id, $montant, $description, $date_transaction) {
    $stmt = $connection->prepare("
        UPDATE transactions 
        SET category_id = ?, montant = ?, description = ?, date_transaction = ?
        WHERE id = ? AND user_id = ?
    ");
    return $stmt->execute([$category_id, $montant, $description, $date_transaction, $id, $user_id]);
}


function listTransactions($connection, $user_id) {
    $query = "
    SELECT t.*, c.nom AS category_name, c.type
    FROM Transactions t
    JOIN categories c ON t.category_id = c.id
    WHERE t.user_id = ?
    ORDER BY t.date_transaction DESC
    ";

    $stmt = $connection->prepare($query);
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function listTransactionsByMonth($connection, $user_id, $year, $month) {
    $query = "
    SELECT t.*, c.nom AS category_name, c.type
    FROM Transactions t
    JOIN categories c ON t.category_id = c.id
    WHERE t.user_id = ?
    AND YEAR(t.date_transaction) = ?
    AND MONTH(t.date_transaction) = ?
    ORDER BY t.date_transaction DESC
    ";

    $stmt = $connection->prepare($query);
    $stmt->execute([$user_id, $year, $month]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>