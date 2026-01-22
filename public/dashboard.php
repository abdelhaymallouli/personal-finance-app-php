<?php
// Include the necessary PHP files for transactions and config
require_once '../includes/dashboard.php';
require_once '../config/config.php';
require_once '../includes/transactions.php';

session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Get the current year and month if they are provided
$year = $_GET['year'] ?? date('Y');
$month = $_GET['month'] ?? date('m');

// Get the balance
$balance = soldUser($connection);

// Get the current month summary: total income and expenses
$totalIncomes = totalIncomesByCategory('Salaire', $connection); // Example for income category
$totalExpenses = totalExpensesByCategory('Transport', $connection); // Example for expense category

// Calculate period change (could be profit/loss)
$periodChange = $totalIncomes - $totalExpenses;

// Get income and expenses by category
$income_categories = ['Salaire', 'Investissement', 'Autre']; // Example categories
$expenses_categories = ['Transport', 'Alimentation', 'Logement', 'Healthcare', 'Education', 'Clothes']; // Match categories in image

$incomesByCategory = [];
foreach ($income_categories as $category) {
    $incomesByCategory[$category] = totalIncomesByCategory($category, $connection);
}

$expensesByCategory = [];
foreach ($expenses_categories as $category) {
    $expensesByCategory[$category] = totalExpensesByCategory($category, $connection);
}

// Get the highest income and expense for the current month
$highest_income = highestIncome($connection, $user_id, $year, $month);
$highest_expense = highestExpense($connection, $user_id, $year, $month);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MonBudget Financial Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
<?php 

include '../template/header.php'; 
?>

<div class="main-content">
    <h1 class="page-title"><i class="fas fa-chart-line"></i> Financial Dashboard</h1>
    
    <div class="dashboard-cards">
        <div class="card">
            <div class="card-title">Total Balance</div>
            <div class="card-value">$ <?php echo number_format($balance, 0); ?></div>
        </div>


        <div class="card">
            <div class="card-title">Total Period Change</div>
            <div class="card-value <?php echo $periodChange >= 0 ? 'positive' : 'negative'; ?>">
                $ <?php echo number_format($periodChange, 0); ?>
            </div>
        </div>


        <div class="card">
            <div class="card-title">Total Period Expenses</div>
            <div class="card-value <?php echo  'negative'; ?>">
                $ <?php echo number_format($totalExpenses, 2); ?></div>
        </div>


        <div class="card">
            <div class="card-title">Total Period Income</div>
            <div class="card-value">$ <?php echo number_format($totalIncomes, 2); ?></div>
        </div>
    </div>


    <div class="summary-section">
        <h3><i class="fas fa-calendar-alt"></i> Current Month Summary</h3>
        <div class="summary-cards">
            <div class="card">
                <div class="card-title">Total Income for <?php echo date('F, Y'); ?></div>
                <div class="card-value">$ <?php echo number_format($totalIncomes, 2); ?></div>
            </div>


            <div class="card">
                <div class="card-title">Total Expenses for <?php echo date('F, Y'); ?></div>
                <div class="card-value">$ <?php echo number_format($totalExpenses, 2); ?></div>
            </div>
        </div>
    </div>


    <div class="category-section">
        <h3><i class="fas fa-money-bill-wave"></i> Income by Category</h3>
        <div class="category-cards">
            <?php foreach ($incomesByCategory as $category => $income) { ?>
                <div class="card">
                    <div class="card-title"><?php echo $category; ?> Income</div>
                    <div class="card-value">$ <?php echo number_format($income, 2); ?></div>
                </div>
            <?php } ?>
        </div>
    </div>


    <div class="category-section">
        <h3><i class="fas fa-credit-card"></i> Expenses by Category</h3>
        <div class="expense-categories">
            <?php 
            $icons = [
                'Transport' => 'fa-car',
                'Alimentation' => 'fa-utensils',
                'Logement' => 'fa-home',
                'Healthcare' => 'fa-heartbeat',
                'Education' => 'fa-graduation-cap',
                'Clothes' => 'fa-tshirt'
            ];
            
            $classes = [
                'Transport' => 'transport',
                'Alimentation' => 'food',
                'Logement' => 'housing',
                'Healthcare' => 'healthcare',
                'Education' => 'education',
                'Clothes' => 'clothes'
            ];
            
            foreach ($expensesByCategory as $category => $expense) { 
                $percentage = $totalExpenses > 0 ? round(($expense / $totalExpenses) * 100, 1) : 0;
                $iconClass = $icons[$category] ?? 'fa-tag';
                $colorClass = $classes[$category] ?? '';
            ?>
                <div class="expense-item">
                    <div class="expense-info">
                        <div class="expense-icon <?php echo $colorClass; ?>-icon">
                            <i class="fas <?php echo $iconClass; ?>"></i>
                        </div>
                        <div class="expense-details">
                            <div class="expense-name"><?php echo $category; ?></div>
                            <div class="expense-value">$ <?php echo number_format($expense, 2); ?></div>
                            <div class="expense-percentage"><?php echo $percentage; ?>% of total</div>
                            <div class="progress-container">
                                <div class="progress-bar <?php echo $colorClass; ?>-bar" style="width: <?php echo $percentage; ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Highest Income and Expense for Current Month -->
    <div class="highest-section">
        <h3><i class="fas fa-bolt"></i> Highest Income and Expense This Month</h3>
        <div class="summary-cards">

            <div class="card">
                <div class="card-title">Highest Income Transaction</div>
                <div class="card-value positive">$ <?php echo number_format($highest_income, 2); ?></div>
                <div class="card-footer">
                    <div class="percentage positive">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <span>on <?php echo date('M d, Y'); ?></span>
                </div>
            </div>


            <div class="card">
                <div class="card-title">Highest Expense Transaction</div>
                <div class="card-value negative">$ <?php echo number_format($highest_expense, 2); ?></div>
                <div class="card-footer">
                    <div class="percentage negative">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <span>on <?php echo date('M d, Y'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <?php 

    include '../template/footer.php'; 
    ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
</body>
</html>