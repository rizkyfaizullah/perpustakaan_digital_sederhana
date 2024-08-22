<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Update data pengguna di database
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
    $stmt->execute([$name, $email, $role, $id]);

    header('Location: manage_users.php');
    exit;
}

// Ambil data pengguna untuk diedit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();
} else {
    header('Location: manage_users.php');
    exit;
}

require 'header_admin.php';
?>

<main class="container mx-auto p-4 flex-grow">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">Edit Pengguna</h1>
        <a href="manage_users.php" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600">Kembali</a>
    </div>

    <!-- Form untuk mengedit pengguna -->
    <form action="edit_user.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Nama:</label>
            <input type="text" id="name" name="name" class="mt-1 p-2 w-full border rounded-lg" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email:</label>
            <input type="email" id="email" name="email" class="mt-1 p-2 w-full border rounded-lg" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="mb-4">
            <label for="role" class="block text-gray-700">Peran:</label>
            <select id="role" name="role" class="mt-1 p-2 w-full border rounded-lg" required>
                <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Perbarui Pengguna</button>
    </form>
</main>

<?php
require 'footer.php';
?>