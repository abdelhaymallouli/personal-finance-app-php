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
    <title>Add Transaction</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #4338ca;
            --background-dark: #0f172a;
            --card-dark: #1e293b;
            --text-light: #f9fafb;
            --text-secondary: #94a3b8;
            --positive-green: #10b981;
            --negative-red: #ef4444;
            --border-color: #2d3748;
            --neutral-gray: #475569;
            --border-radius: 12px;
            --box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        body {
            background-color: transparent;
            color: var(--text-light);
            font-size: 16px;
            line-height: 1.5;
            /* No centering needed as this is inside a modal */
            padding: 0;
            margin: 0;
        }

        .form-container {
            width: 100%;
            padding: 20px 0;
            /* No background or borders as the modal handles that */
        }

        .form-title {

            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            margin-left: 20px;
            color: var(--text-light);
            display: flex;
            align-items: center;
        }

        .form-title i {
            margin-right: 10px;
            color: var(--primary-color);
        }

        .error-message {
            background-color: rgba(239, 68, 68, 0.1);
            border-left: 3px solid var(--negative-red);
            color: var(--negative-red);
            padding: 8px 12px;
            margin-bottom: 15px;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 500;
        }

        input, select {
            width: 100%;
            padding: 10px 14px;
            background-color: var(--background-dark);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-light);
            font-size: 15px;
            transition: var(--transition);
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.3);
        }

        input[type="date"] {
            appearance: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        button:hover {
            background-color: var(--primary-dark);
        }

        button i {
            margin-right: 8px;
        }

        select option {
            background-color: var(--background-dark);
            color: var(--text-light);
        }

        .type-selector {
            display: flex;
            margin-bottom: 15px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .type-selector label {
            flex: 1;
            margin: 0;
            position: relative;
        }

        .type-selector input[type="radio"] {
            opacity: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .type-option {
            display: block;
            padding: 10px;
            text-align: center;
            background-color: var(--background-dark);
            transition: var(--transition);
            cursor: pointer;
            font-size: 14px;
        }

        .type-selector input[type="radio"]:checked + .type-option {
            background-color: var(--primary-color);
            color: white;
        }

        .income-option {
            color: var(--positive-green);
        }

        .expense-option {
            color: var(--negative-red);
        }

        .type-selector input[type="radio"]:checked + .income-option,
        .type-selector input[type="radio"]:checked + .expense-option {
            color: white;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 class="form-title"><i class="fas fa-exchange-alt"></i>Add Transaction</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <div><?php echo $error; ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="type-selector">
                <label>
                    <input type="radio" name="type" value="revenu" <?= ($_POST['type'] ?? 'revenu') === 'revenu' ? 'checked' : '' ?>>
                    <span class="type-option income-option"><i class="fas fa-plus-circle"></i> Income</span>
                </label>
                <label>
                    <input type="radio" name="type" value="depense" <?= ($_POST['type'] ?? '') === 'depense' ? 'checked' : '' ?>>
                    <span class="type-option expense-option"><i class="fas fa-minus-circle"></i> Expense</span>
                </label>
            </div>
            
            <div class="form-group">
                <label>Amount:</label>
                <input type="number" name="montant" step="0.01" required value="<?= htmlspecialchars($_POST['montant'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label>Category:</label>
                <select name="category_id" required>
                    <option value="">-- Select --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= ($_POST['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nom']) ?> (<?= $cat['type'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Description:</label>
                <input type="text" name="description" value="<?= htmlspecialchars($_POST['description'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label>Date:</label>
                <input type="date" name="date_transaction" value="<?= htmlspecialchars($_POST['date_transaction'] ?? date('Y-m-d')) ?>">
            </div>
            
            <button type="submit"><i class="fas fa-save"></i> Add Transaction</button>
        </form>
    </div>


</body>
</html>