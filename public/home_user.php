<?php
require 'header_user.php';
?>

<h1 class="text-3xl font-bold mb-4">Selamat Datang, User!</h1>
<p class="text-lg mb-4">Ini adalah dashboard Anda di mana Anda dapat mengelola data buku.</p>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- Card untuk Mengelola Data Buku -->
    <div class="bg-gray-200 p-4 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-2">Manajemen Data Buku</h2>
        <p class="text-gray-700 mb-2">Lihat dan kelola data buku.</p>
        <a href="data_buku_user.php" class="text-blue-500 hover:underline">Kelola Data Buku</a>
    </div>
</div>

<?php
require 'footer.php';
?>