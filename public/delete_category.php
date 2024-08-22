<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require '../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus data kategori dari database
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);

    // Redirect ke halaman kategori buku
    header('Location: kategori_buku.php');
    exit;
}
