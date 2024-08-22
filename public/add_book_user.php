<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit;
}

require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $title = $_POST['title'];
    $category_id = $_POST['category'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];

    // Tentukan folder upload
    $uploadDir = __DIR__ . '/uploads/';

    // Tangani upload file buku
    $book_file = null;
    if (isset($_FILES['book_file']) && $_FILES['book_file']['error'] === UPLOAD_ERR_OK) {
        $book_file = basename($_FILES['book_file']['name']);
        $uploadFilePath = $uploadDir . $book_file;
        if (!move_uploaded_file($_FILES['book_file']['tmp_name'], $uploadFilePath)) {
            echo "Gagal meng-upload file buku.";
            exit;
        }
    }

    // Tangani upload cover image
    $cover_image = null;
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
        $cover_image = basename($_FILES['cover_image']['name']);
        $uploadCoverPath = $uploadDir . $cover_image;
        if (!move_uploaded_file($_FILES['cover_image']['tmp_name'], $uploadCoverPath)) {
            echo "Gagal meng-upload cover image.";
            exit;
        }
    }

    // Masukkan data buku ke database
    $stmt = $pdo->prepare("
        INSERT INTO books (title, category_id, description, quantity, book_file, cover_image, user_id)
        VALUES (:title, :category_id, :description, :quantity, :book_file, :cover_image, :user_id)
    ");
    $stmt->execute([
        ':title' => $title,
        ':category_id' => $category_id,
        ':description' => $description,
        ':quantity' => $quantity,
        ':book_file' => $book_file,
        ':cover_image' => $cover_image,
    ]);

    // Redirect ke halaman data buku user
    header('Location: data_buku_user.php');
    exit;
}
