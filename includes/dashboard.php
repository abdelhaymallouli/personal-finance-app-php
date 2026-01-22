<?php
// Function to get the balance (solde) for the user
function soldUser($connection) {
    global $user_id;
    $query = "
        SELECT 
            SUM(CASE WHEN c.type = 'revenu' THEN t.montant ELSE 0 END) - 
            SUM(CASE WHEN c.type = 'depense' THEN t.montant ELSE 0 END) AS solde
        FROM transactions t
        JOIN categories c ON t.category_id = c.id
        WHERE t.user_id = :user_id
    ";

    $stmt = $connection->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    return $data['solde'] ?? 0;
}

// Function to get user details (name, email, etc.)
function detailsUser($connection) {
    global $user_id;
    $query = "SELECT nom, email FROM users WHERE id = :user_id";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to get the total income by category for the current user
function totalIncomesByCategory($category, $connection) {
    global $user_id;
    $query = "
        SELECT SUM(t.montant) AS total_income
        FROM transactions t
        JOIN categories c ON t.category_id = c.id
        WHERE t.user_id = :user_id
        AND c.nom = :category
        AND c.type = 'revenu'
    ";

    $stmt = $connection->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    return $data['total_income'] ?? 0;
}

// Function to get the total expense by category for the current user
function totalExpensesByCategory($category, $connection) {
    global $user_id;
    $query = "
        SELECT SUM(t.montant) AS total_expense
        FROM transactions t
        JOIN categories c ON t.category_id = c.id
        WHERE t.user_id = :user_id
        AND c.nom = :category
        AND c.type = 'depense'
    ";

    $stmt = $connection->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    return $data['total_expense'] ?? 0;
}

function highestIncome($connection, $user_id, $year, $month) {
    $query = "
        SELECT MAX(t.montant) AS highest_income
        FROM transactions t
        JOIN categories c ON t.category_id = c.id
        WHERE t.user_id = :user_id
        AND c.type = 'revenu'
        AND YEAR(t.date_transaction) = :year
        AND MONTH(t.date_transaction) = :month
    ";

    $stmt = $connection->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    return $data['highest_income'] ?? 0;  // Return 0 if no income found
}


function highestExpense($connection, $user_id, $year, $month) {
    $query = "
        SELECT MAX(t.montant) AS highest_expense
        FROM transactions t
        JOIN categories c ON t.category_id = c.id
        WHERE t.user_id = :user_id
        AND c.type = 'depense'
        AND YEAR(t.date_transaction) = :year
        AND MONTH(t.date_transaction) = :month
    ";

    $stmt = $connection->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    return $data['highest_expense'] ?? 0;  // Return 0 if no expense found
}

?>