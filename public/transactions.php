<?php 
require_once '../includes/transactions.php';
require_once '../config/config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$year = $_GET['year'] ?? null;
$month = $_GET['month'] ?? null;

if ($year && $month) {
    $transactions = listTransactionsByMonth($connection, $year, $month);
} else {
    $transactions = listTransactions($connection);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History - MonBudget</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/transactions.css?v=<?php echo time(); ?>">

</head>
<body>

<?php 
// Include the header
include '../template/header.php'; 
?>

<div class="content">
    <h1 class="page-title"><i class="fas fa-exchange-alt"></i> Transaction History</h1>
    
    <div class="action-bar">
        <a href="#" class="btn btn-success">
            <i class="fas fa-plus"></i> Add Transaction
        </a>
    </div>
        <!-- Add this just before closing </body> -->
    <div id="transactionModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <iframe src="add_transaction.php" frameborder="0"></iframe>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="transactions.php" class="filter-form">
            <div class="form-group">
                <label for="year">Year</label>
                <select name="year" id="year">
                    <option value="">All Years</option>
                    <?php for ($y = date("Y"); $y >= 2000; $y--): ?>
                        <option value="<?= $y ?>" <?= ($year == $y) ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="month">Month</label>
                <select name="month" id="month">
                        <option value="">All Months</option>
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                            <option value="<?= $m ?>" <?= ($month == $m) ? 'selected' : '' ?>><?= $m ?></option>
                        <?php endfor; ?>
                    </select>
            </div>
            
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i> Apply Filters
            </button>
        </form>
    </div>
    
    <!-- Transactions Card -->
    <div class="content-card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-history"></i> Transaction History
            </div>
        </div>
        
        <?php if (empty($transactions)): ?>
            <div class="empty-state">
                <i class="fas fa-receipt"></i>
                <h3>No transactions found</h3>
                <p>There are no transactions matching your filters. Try adjusting your filters or add new transactions.</p>
            </div>
        <?php else: ?>
            <table class="transactions-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Currency</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $t): ?>
                        <?php 
                            $categoryIcons = [
                                // Income categories
                                'Salaire' => ['fa-money-bill-wave', 'bg-salaire'],
                                'Bourse' => ['fa-graduation-cap', 'bg-bourse'],
                                'Ventes' => ['fa-store', 'bg-ventes'],
                                'Autres' => ['fa-coins', 'bg-autres-income'],
                                
                                // Expense categories
                                'Logement' => ['fa-home', 'bg-logement'],
                                'Transport' => ['fa-car', 'bg-transport'],
                                'Alimentation' => ['fa-utensils', 'bg-alimentation'],
                                'Santé' => ['fa-heartbeat', 'bg-sante'],
                                'Divertissement' => ['fa-tv', 'bg-divertissement'],
                                'Éducation' => ['fa-book', 'bg-education'],
                                'Autres' => ['fa-stream', 'bg-autres-expense']
                            ];
                            
                            $category = htmlspecialchars($t['category_name'] ?? 'Autres');
                            $iconPair = $categoryIcons[$category] ?? ['fa-question-circle', 'bg-autres-expense'];
                            $isExpense = ($t['type'] ?? '') === 'depense' || (float)($t['montant'] ?? 0) < 0;
                        ?>
                        <tr>
                            <td>
                                <div class="category">
                                    <div class="category-icon <?= $iconPair[1] ?>">
                                        <i class="fas <?= $iconPair[0] ?>"></i>
                                    </div>
                                    <div class="category-name"><?= $category ?></div>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($t['date_transaction'] ?? date('Y-m-d')) ?></td>
                            <td><?= htmlspecialchars($t['description'] ?? 'Transaction description') ?></td>
                            <td class="<?= $isExpense ? 'amount-negative' : 'amount-positive' ?>">
                                <?= $isExpense ? '-' : '+' ?><?= number_format(abs((float)($t['montant'] ?? 0)), 2) ?>
                            </td>
                            <td><?= htmlspecialchars($t['currency'] ?? 'USD') ?></td>
                            <td>
                                <div class="action-buttons">
                                <a href="#" onclick="openEditModal(<?= $t['id'] ?? 0 ?>)" class="btn btn-sm btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Edit Transaction Modal -->
                                    <div id="editTransactionModal" class="modal">
                                        <div class="modal-content">
                                            <span class="close">&times;</span>
                                            <iframe id="editTransactionFrame" src="" frameborder="0"></iframe>
                                        </div>
                                    </div>

                                    <a href="delete_transaction.php?id=<?= $t['id'] ?? '' ?>" 
                                       onclick="return confirm('Are you sure you want to delete this transaction?')" 
                                       class="btn btn-sm btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php 
// Include the footer
include '../template/footer.php'; 
?>

</body>
<script src="../assets/js/script.js"></script>

</html>