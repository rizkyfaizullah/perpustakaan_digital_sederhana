<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password
    $role = $_POST['role'];

    // Masukkan data pengguna ke database
    $stmt = $pdo->prepare("
        INSERT INTO users (name, email, password, role)
        VALUES (:name, :email, :password, :role)
    ");
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':password' => $password,
        ':role' => $role,
    ]);

    // Redirect ke halaman kelola pengguna
    header('Location: manage_users.php');
    exit;
}
