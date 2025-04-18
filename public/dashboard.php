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
    <title>Ekash Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
<?php 
// Include the header
include '../template/header.php'; 
?>

<div class="dashboard-cards">
    <!-- Display Current Balance -->
    <div class="card">
        <div class="card-title">Total Balance</div>
        <div class="card-value">$ <?php echo number_format($balance, 0); ?></div>
    </div>

    <!-- Display Total Period Change -->
    <div class="card">
        <div class="card-title">Total Period Change</div>
        <div class="card-value">$ <?php echo number_format($periodChange, 0); ?></div>
    </div>

    <!-- Display Total Period Expenses -->
    <div class="card">
        <div class="card-title">Total Period Expenses</div>
        <div class="card-value">$ <?php echo number_format($totalExpenses, 2); ?></div>
    </div>

    <!-- Display Total Period Income -->
    <div class="card">
        <div class="card-title">Total Period Income</div>
        <div class="card-value">$ <?php echo number_format($totalIncomes, 2); ?></div>
    </div>
</div>

<!-- Current Month Summary Section -->
<div class="summary-section">
    <h3>Current Month Summary</h3>
    <div class="summary-cards">
        <!-- Total Income -->
        <div class="card">
            <div class="card-title">Total Income for <?php echo date('F, Y'); ?></div>
            <div class="card-value">$ <?php echo number_format($totalIncomes, 2); ?></div>
        </div>

        <!-- Total Expenses -->
        <div class="card">
            <div class="card-title">Total Expenses for <?php echo date('F, Y'); ?></div>
            <div class="card-value">$ <?php echo number_format($totalExpenses, 2); ?></div>
        </div>
    </div>
</div>

<!-- Income and Expenses by Category -->
<div class="category-section">
    <h3>Income by Category</h3>
    <div class="category-cards">
        <?php foreach ($incomesByCategory as $category => $income) { ?>
            <div class="card">
                <div class="card-title"><?php echo $category; ?> Income</div>
                <div class="card-value">$ <?php echo number_format($income, 2); ?></div>
            </div>
        <?php } ?>
    </div>

    <h3>Expenses by Category</h3>
    <div class="category-cards">
        <?php foreach ($expensesByCategory as $category => $expense) { ?>
            <div class="card">
                <div class="card-title"><?php echo $category; ?> Expense</div>
                <div class="card-value">$ <?php echo number_format($expense, 2); ?></div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Highest Income and Expense for Current Month -->
<div class="highest-section">
    <h3>Highest Income and Expense This Month</h3>
    <div class="summary-cards">
        <!-- Highest Income -->
        <div class="card">
            <div class="card-title">Highest Income</div>
            <div class="card-value">$ <?php echo number_format($highest_income, 2); ?></div>
        </div>

        <!-- Highest Expense -->
        <div class="card">
            <div class="card-title">Highest Expense</div>
            <div class="card-value">$ <?php echo number_format($highest_expense, 2); ?></div>
        </div>
    </div>
</div>

<?php 
// Include the footer
include '../template/footer.php'; 
?>
</body>
</html>
