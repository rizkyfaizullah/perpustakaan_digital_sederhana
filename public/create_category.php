<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require '../includes/db.php';
require 'header_admin.php';
?>

<main class="container mx-auto p-4 flex-grow">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">Tambah Kategori</h1>
        <a href="kategori_buku.php" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600">Kembali</a>
    </div>

    <!-- Form untuk menambah kategori baru -->
    <form action="add_category.php" method="POST">
        <div class="mb-4">
            <label for="category_name" class="block text-gray-700">Nama Kategori:</label>
            <input type="text" id="category_name" name="category_name" class="mt-1 p-2 w-full border rounded-lg" placeholder="Masukkan nama kategori" required>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Tambah Kategori</button>
    </form>
</main>

<?php
require 'footer.php';
?>