<?php 
require_once '../includes/transactions.php';
require_once '../config/config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$year = $_GET['year'] ?? null;
$month = $_GET['month'] ?? null;

if ($year && $month) {
    $transactions = listTransactionsByMonth($connection, $user_id, $year, $month);
} else {
    $transactions = listTransactions($connection, $user_id);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History - Enfix</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
   :root {
            --dark-blue: #111827;
            --darker-blue: #0c1323;
            --light-blue: #3b82f6;
            --accent-blue: #4338ca; 
            --sidebar-blue: #4338ca;
            --button-hover: #2563eb;
            --input-bg: #1f2937;
            --text-light: #f9fafb;
            --text-gray: #9ca3af;
            --border-color: #2d3748;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        
        body {
            background-color: var(--dark-blue);
            color: var(--text-light);
            display: flex;
            min-height: 100vh;
        }
        
        /* Content */
        .content {
            flex-grow: 1;
            padding: 0 30px 30px;
        }
        
        .content-card {
            background-color: var(--darker-blue);
            border-radius: 12px;
            padding: 20px;
        }
        
        .content-header {
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 600;
        }
        
        /* Transactions Table */
        .transactions-table {
            width: 100%;
            border-collapse: collapse;
            overflow-y: auto;
        }
        
        .transactions-table thead th {
            text-align: left;
            padding: 15px 10px;
            color: var(--text-gray);
            font-weight: 500;
            border-bottom: 1px solid var(--border-color);
        }

    
        .transactions-table tbody td {
            padding: 20px 10px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-light);
        }
        
        .transactions-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .category {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .category-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .category-name {
            font-weight: 500;
        }
        
        .bg-teal {
            background-color: #0d9488;
        }
        
        .bg-blue {
            background-color: #3b82f6;
        }
        
        .bg-cyan {
            background-color: #06b6d4;
        }
        
        .bg-indigo {
            background-color: #6366f1;
        }
        
        .amount-negative {
            color: #ef4444;
        }
        
        .amount-positive {
            color: #10b981;
        }
        
        /* Filter Form */
        .filter-form {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background-color: var(--darker-blue);
            border-radius: 8px;
        }
        
        .form-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .form-group label {
            color: var(--text-gray);
        }
        
        .form-group select {
            padding: 8px 12px;
            border-radius: 6px;
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            color: var(--text-light);
        }
        
        .filter-button {
            padding: 8px 16px;
            background-color: var(--light-blue);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .filter-button:hover {
            background-color: var(--button-hover);
        }
        
        /* Footer */
        .footer {
            padding: 20px 30px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            color: var(--text-gray);
            font-size: 14px;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
        }
        
        .social-links a {
            color: var(--text-gray);
            text-decoration: none;
        }
        
        .social-links a:hover {
            color: var(--text-light);
        }
        
        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .edit-btn, .delete-btn {
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }
        
        .edit-btn {
            background-color: var(--light-blue);
            color: white;
        }
        
        .delete-btn {
            background-color: #ef4444;
            color: white;
        }
        
        /* Add transaction button */
        .add-transaction {
            display: inline-block;
            padding: 10px 15px;
            background-color: var(--light-blue);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .add-transaction:hover {
            background-color: var(--button-hover);
        }
    </style>
</head>
<body>


<?php 
// Include the header
include '../template/header.php'; 
?>

        <!-- Content -->
        <div class="content">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
            <a href="add_transaction.php" class="add-transaction">Add Transaction</a>
            
            <!-- Filter Form -->
            <form method="GET" action="transactions.php" class="filter-form">
                <div class="form-group">
                    <label>Year:</label>
                    <select name="year">
                        <option value="">All</option>
                        <?php for ($y = date("Y"); $y >= 2000; $y--): ?>
                            <option value="<?= $y ?>" <?= ($year == $y) ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Month:</label>
                    <select name="month">
                        <option value="">All</option>
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                            <option value="<?= $m ?>" <?= ($month == $m) ? 'selected' : '' ?>><?= $m ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <button type="submit" class="filter-button">Filter</button>
            </form>
            
            <!-- Transactions Card -->
            <div class="content-card">
                <div class="content-header">Transaction History</div>
                
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
                        <?php if (empty($transactions)): ?>
                            <tr>
                                <td colspan="6">No transactions found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transactions as $t): ?>
                                <?php 
                                    // Determine category icon and color based on category name
                                    $categoryIcons = [
                                        'Beauty' => ['fa-spa', 'bg-teal'],
                                        'Bills & Fees' => ['fa-file-invoice', 'bg-blue'],
                                        'Car' => ['fa-car', 'bg-cyan'],
                                        'Education' => ['fa-graduation-cap', 'bg-indigo'],
                                        'Entertainment' => ['fa-tv', 'bg-blue'],
                                        'Food' => ['fa-utensils', 'bg-teal'],
                                        'Shopping' => ['fa-shopping-bag', 'bg-cyan'],
                                        'Travel' => ['fa-plane', 'bg-indigo'],
                                        'Other' => ['fa-stream', 'bg-blue']
                                    ];
                                    
                                    $category = htmlspecialchars($t['category_name'] ?? 'Other');
                                    $iconPair = $categoryIcons[$category] ?? ['fa-question', 'bg-blue'];
                                    $isExpense = ($t['type'] ?? '') === 'expense' || (float)($t['montant'] ?? 0) < 0;
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
                                    <td><?= htmlspecialchars($t['date_transaction'] ?? '12.12.2023') ?></td>
                                    <td><?= htmlspecialchars($t['description'] ?? 'Grocery Items and Beverage soft drinks') ?></td>
                                    <td class="<?= $isExpense ? 'amount-negative' : 'amount-positive' ?>">
                                        <?= $isExpense ? '-' : '+' ?><?= abs((float)($t['montant'] ?? 32.20)) ?>
                                    </td>
                                    <td><?= htmlspecialchars($t['currency'] ?? 'USD') ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="edit_transactions.php?id=<?= $t['id'] ?? '' ?>" class="edit-btn">Edit</a>
                                            <a href="delete_transaction.php?id=<?= $t['id'] ?? '' ?>" onclick="return confirm('Confirm deletion?')" class="delete-btn">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <?php 
// Include the header
include '../template/footer.php'; 
?>

</body>
</html>