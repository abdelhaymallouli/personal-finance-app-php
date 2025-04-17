<?php
session_start();

require_once __DIR__ . '/../includes/user.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php'); 
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $errors[] = "Veuillez remplir tous les champs.";
    } else {
        $user = login($email, $password, $connection);
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nom'];
            header("Location: dashboard.php");
            exit();
        } else {
            $errors[] = "Email ou mot de passe incorrect.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MonBudget</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="image-side">
            <div class="logo">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="white">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                </svg>
                Welcome to MonBudget
            </div>
            <div class="social-icons">
                <div class="social-icon">
                    <i class="fab fa-facebook-f"></i>
                </div>
                <div class="social-icon">
                    <i class="fab fa-twitter"></i>
                </div>
                <div class="social-icon">
                    <i class="fab fa-linkedin-in"></i>
                </div>
                <div class="social-icon">
                    <i class="fab fa-github"></i>
                </div>
            </div>
            <div class="help-links">
                <a href="#">Have an issue with 2-factor authentication?</a>
                <a href="#">Privacy Policy</a>
            </div>
        </div>
        <div class="form-side">
            <div class="form-header">Sign In</div>
            <form method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php if(isset($email)) echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
                    <?php if(isset($errors['email'])): ?>
                        <div class="error-message"><?php echo htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password">
                    <?php if(isset($errors['password'])): ?>
                        <div class="error-message"><?php echo htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php endif; ?>
                </div>

                <?php if(isset($errors['incorrect'])): ?>
                    <div class="error-message"><?php echo htmlspecialchars($errors['incorrect'], ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>
                
                <button type="submit" class="submit-button">Sign In</button>
                
                <div class="form-footer">
                    <div>Don't have an account? <a href="register.php">Sign Up</a></div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
