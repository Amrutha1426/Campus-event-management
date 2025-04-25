<?php
session_start();
require_once 'db.php';

$error = ''; // ✅ Always initialized to prevent undefined variable warning

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];

        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Invalid credentials';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Event Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 min-h-screen">

<?php include 'includes/header.php'; ?>

<div class="flex items-center justify-center min-h-screen px-4">
  <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg mt-[-80px]">
    <!-- Logo -->
    <div class="flex justify-center mb-6">
      <img src="https://t4.ftcdn.net/jpg/06/58/52/69/360_F_658526949_OPtABJyZyniWxJKa4TTpVX1SwdRunSEq.jpg" alt="Campus Event Logo" class="h-16 rounded-full shadow-md">
    </div>

    <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">Login to Your Account</h2>

    <?php if (!empty($error)): ?>
      <div class="bg-red-100 text-red-700 p-3 rounded-md mb-4 text-sm">
        <?php echo htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-5">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
        <input type="email" id="email" name="email" required
               class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password" required
               class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
      </div>

      <button type="submit"
              class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition">
        Login
      </button>
    </form>

    <p class="text-center text-sm mt-6 text-gray-600">
      Don't have an account?
      <a href="register.php" class="text-blue-600 hover:underline font-semibold">Register Now</a>
    </p>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
