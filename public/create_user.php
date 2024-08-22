<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require 'header_admin.php';
?>

<main class="container mx-auto p-4 flex-grow">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">Tambah Pengguna</h1>
        <a href="manage_users.php" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600">Kembali</a>
    </div>

    <!-- Form untuk menambah pengguna baru -->
    <form action="add_user.php" method="POST">
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Nama:</label>
            <input type="text" id="name" name="name" class="mt-1 p-2 w-full border rounded-lg" placeholder="Masukkan nama pengguna" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email:</label>
            <input type="email" id="email" name="email" class="mt-1 p-2 w-full border rounded-lg" placeholder="Masukkan email pengguna" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password:</label>
            <input type="password" id="password" name="password" class="mt-1 p-2 w-full border rounded-lg" placeholder="Masukkan password pengguna" required>
        </div>
        <div class="mb-4">
            <label for="role" class="block text-gray-700">Peran:</label>
            <select id="role" name="role" class="mt-1 p-2 w-full border rounded-lg" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Tambah Pengguna</button>
    </form>
</main>

<?php
require 'footer.php';
?>