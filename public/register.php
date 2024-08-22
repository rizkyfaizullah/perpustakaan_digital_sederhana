<?php
session_start();
require '../includes/db.php';
require '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        if (registerUser($name, $email, $password)) {
            $_SESSION['success_message'] = 'Registration successful! You can now log in.';
            header('Location: login.php');
            exit;
        } else {
            $error = "Registration failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body class="bg-gray-200 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-2xl font-bold text-center mb-6">Register</h2>
            <?php if (isset($error)): ?>
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <form action="register.php" method="POST">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Name:</label>
                    <input type="text" id="name" name="name" class="mt-1 p-2 w-full border rounded-lg" placeholder="Enter your name" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email:</label>
                    <input type="email" id="email" name="email" class="mt-1 p-2 w-full border rounded-lg" placeholder="Enter your email" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password:</label>
                    <input type="password" id="password" name="password" class="mt-1 p-2 w-full border rounded-lg" placeholder="Enter your password" required>
                </div>
                <div class="mb-4">
                    <label for="confirm_password" class="block text-gray-700">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="mt-1 p-2 w-full border rounded-lg" placeholder="Confirm your password" required>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Register</button>
            </form>
            <p class="mt-4 text-center">
                <a href="login.php" class="text-blue-500 hover:underline">Already have an account? Login</a>
            </p>
        </div>
    </div>
    <!-- Font Awesome CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>

</html>