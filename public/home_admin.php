<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require 'header_admin.php';
?>

<h1 class="text-3xl font-bold mb-4">Selamat Datang, Admin!</h1>
<p class="text-lg mb-4">Ini adalah dashboard Anda di mana Anda dapat mengelola pengguna dan mengelola data buku.</p>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <!-- Card untuk Mengelola Pengguna -->
    <div class="bg-gray-200 p-4 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-2">Manajemen Pengguna</h2>
        <p class="text-gray-700 mb-2">Kelola akun dan izin pengguna.</p>
        <a href="manage_users.php" class="text-blue-500 hover:underline">Kelola Pengguna</a>
    </div>
    <!-- Card untuk Mengelola Kategori Buku -->
    <div class="bg-gray-200 p-4 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-2">Manajemen Kategori Buku</h2>
        <p class="text-gray-700 mb-2">Lihat dan kelola kategori buku.</p>
        <a href="kategori_buku.php" class="text-blue-500 hover:underline">Kelola Kategori Buku</a>
    </div>
    <!-- Card untuk Mengelola Data Buku -->
    <div class="bg-gray-200 p-4 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-2">Manajemen Data Buku</h2>
        <p class="text-gray-700 mb-2">Lihat dan kelola data buku.</p>
        <a href="data_buku.php" class="text-blue-500 hover:underline">Kelola Data Buku</a>
    </div>
</div>

<?php
require 'footer.php';
?>