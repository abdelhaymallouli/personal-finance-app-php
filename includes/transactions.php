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

function updateTransaction($connection, $id, $category_id, $montant, $description, $date_transaction) {
    $stmt = $connection->prepare("
        UPDATE transactions 
        SET category_id = ?, montant = ?, description = ?, date_transaction = ?
        WHERE id = ?
    ");
    return $stmt->execute([$category_id, $montant, $description, $date_transaction, $id]);
}

function listTransactions($connection, $user_id, $year=null, $month = null){
    $query = "
    SELECT t.*, c.nom AS category_name, c.type
    FROM Transactions t
    JOIN categories c ON t.category_id = c.id
    WHERE t.user_id = ? 
    ";
    $params = [$user_id];

    if($year){
        $query .= "AND YEAR(t.date_transaction) = ?";
        $params[]= $year;
    }

    if($month){
        $query .= "AND MONTH(t.date_transaction) = ?";
        $params[]= $month;
    }

    $query .= "ORDER BY t.date_transaction DESC";

    $stmt = $connection->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchALL(PDO::FETCH_ASSOC);

}
?>