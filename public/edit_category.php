<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $category_name = $_POST['category_name'];

    // Update data kategori di database
    $stmt = $pdo->prepare("UPDATE categories SET category_name = ? WHERE id = ?");
    $stmt->execute([$category_name, $id]);

    header('Location: kategori_buku.php');
    exit;
}

// Ambil data kategori untuk diedit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $category = $stmt->fetch();
} else {
    header('Location: kategori_buku.php');
    exit;
}

require 'header_admin.php';
?>

<main class="container mx-auto p-4 flex-grow">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">Edit Kategori</h1>
        <a href="kategori_buku.php" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600">Kembali</a>
    </div>

    <!-- Form untuk mengedit kategori -->
    <form action="edit_category.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($category['id']); ?>">
        <div class="mb-4">
            <label for="category_name" class="block text-gray-700">Nama Kategori:</label>
            <input type="text" id="category_name" name="category_name" class="mt-1 p-2 w-full border rounded-lg" value="<?php echo htmlspecialchars($category['category_name']); ?>" required>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Perbarui Kategori</button>
    </form>
</main>

<?php
require 'footer.php';
?>