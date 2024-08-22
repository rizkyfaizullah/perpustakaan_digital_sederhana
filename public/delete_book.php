<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require '../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil nama file dari database
    $stmt = $pdo->prepare("SELECT book_file, cover_image FROM books WHERE id = ?");
    $stmt->execute([$id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($book) {
        // Tentukan jalur folder uploads di dalam public
        $uploadDir = __DIR__ . '/uploads/';

        // Hapus file buku dari server
        if ($book['book_file']) {
            $bookFilePath = realpath($uploadDir . $book['book_file']);
            if ($bookFilePath && file_exists($bookFilePath)) {
                unlink($bookFilePath);
            }
        }

        // Hapus cover image dari server
        if ($book['cover_image']) {
            $coverImagePath = realpath($uploadDir . $book['cover_image']);
            if ($coverImagePath && file_exists($coverImagePath)) {
                unlink($coverImagePath);
            }
        }

        // Hapus data buku dari database
        $stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
        $stmt->execute([$id]);
    }

    header('Location: data_buku.php');
    exit;
}
