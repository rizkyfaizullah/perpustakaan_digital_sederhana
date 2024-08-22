<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];

    // Masukkan data kategori ke database
    $stmt = $pdo->prepare("
        INSERT INTO categories (category_name)
        VALUES (:category_name)
    ");
    $stmt->execute([
        ':category_name' => $category_name,
    ]);

    // Redirect ke halaman kategori buku
    header('Location: kategori_buku.php');
    exit;
}
