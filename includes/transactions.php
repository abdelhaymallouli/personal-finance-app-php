<?php 
function addTransaction($transaction, $connection) {
    $stmt = $connection->prepare("
        INSERT INTO transactions (user_id, category_id, montant, description, date_transaction)
        VALUES (:user_id, :category_id, :montant, :description, :date_transaction)
    ");
    return $stmt->execute([
        ':user_id' => $transaction['user_id'],
        ':category_id' => $transaction['category_id'],
        ':montant' => $transaction['montant'],
        ':description' => $transaction['description'],
        ':date_transaction' => $transaction['date_transaction']
    ]);
}

function deleteTransaction($connection, $idTransaction) {
    $stmt = $connection->prepare("DELETE FROM transactions WHERE id = :id");
    return $stmt->execute([':id' => $idTransaction]);
}

function editTransaction($newTransaction, $connection) {
    $stmt = $connection->prepare("
        UPDATE transactions
        SET category_id = :category_id, montant = :montant, description = :description, date_transaction = :date_transaction
        WHERE id = :id
    ");
    return $stmt->execute([
        ':category_id' => $newTransaction['category_id'],
        ':montant' => $newTransaction['montant'],
        ':description' => $newTransaction['description'],
        ':date_transaction' => $newTransaction['date_transaction'],
        ':id' => $newTransaction['idTransaction'],
    ]);
}


function listTransactions($connection) {
    global $user_id;
    $query = "
        SELECT t.*, c.nom AS category_name, c.type
        FROM transactions t
        JOIN categories c ON t.category_id = c.id
        WHERE t.user_id = :user_id
        ORDER BY t.date_transaction DESC
    ";
    $stmt = $connection->prepare($query);
    $stmt->execute([':user_id' => $user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function listTransactionsByMonth($connection, $year, $month) {
    global $user_id;
    $query = "
        SELECT t.*, c.nom AS category_name, c.type
        FROM transactions t
        JOIN categories c ON t.category_id = c.id
        WHERE t.user_id = :user_id
        AND YEAR(t.date_transaction) = :year
        AND MONTH(t.date_transaction) = :month
        ORDER BY t.date_transaction DESC
    ";
    $stmt = $connection->prepare($query);
    $stmt->execute([
        ':user_id' => $user_id,
        ':year' => $year,
        ':month' => $month
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>