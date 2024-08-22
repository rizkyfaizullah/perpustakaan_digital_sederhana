<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require '../includes/db.php';

// Fetch users
$query = $pdo->query("SELECT * FROM users");
$users = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
require 'header_admin.php';
?>

<div class="flex justify-between items-center mb-4">
    <h1 class="text-3xl font-bold">Kelola Pengguna</h1>
    <a href="create_user.php" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Tambah Pengguna</a>
</div>
<table class="w-full bg-white border border-gray-300 rounded-lg">
    <thead>
        <tr class="bg-gray-200">
            <th class="p-4 border-b">ID</th>
            <th class="p-4 border-b">Nama</th>
            <th class="p-4 border-b">Email</th>
            <th class="p-4 border-b">Peran</th>
            <th class="p-4 border-b">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td class="p-4 border-b text-center"><?php echo htmlspecialchars($user['id']); ?></td>
                <td class="p-4 border-b text-center"><?php echo htmlspecialchars($user['name']); ?></td>
                <td class="p-4 border-b text-center"><?php echo htmlspecialchars($user['email']); ?></td>
                <td class="p-4 border-b text-center"><?php echo htmlspecialchars($user['role']); ?></td>
                <td class="p-4 border-b text-center">
                    <a href="edit_user.php?id=<?php echo htmlspecialchars($user['id']); ?>" class="text-blue-500 hover:underline">Edit</a>
                    <a href="delete_user.php?id=<?php echo htmlspecialchars($user['id']); ?>" class="text-red-500 hover:underline ml-2" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
require 'footer.php';
?>