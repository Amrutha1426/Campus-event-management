<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'student')");
            $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
            
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['user_name'] = $name;
            $_SESSION['user_role'] = 'student';
            
            header('Location: dashboard.php');
            exit();
        } catch (PDOException $e) {
            $error = 'Email already exists';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Event Management System</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="auth-container">
        <div class="auth-card">
            <h2>Create a New Account</h2>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>

            <p class="auth-links">
                Already have an account? <a href="login.php">Login Here</a>
            </p>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>