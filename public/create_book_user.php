<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit;
}

require '../includes/db.php';

// Ambil kategori untuk dropdown
$categoryQuery = $pdo->query("SELECT * FROM categories");
$categories = $categoryQuery->fetchAll(PDO::FETCH_ASSOC);

require 'header_user.php';
?>

<main class="container mx-auto p-4 flex-grow">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">Tambah Buku</h1>
        <a href="data_buku_user.php" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600">Kembali</a>
    </div>

    <!-- Form untuk menambah buku baru -->
    <form action="add_book.php" method="POST" enctype="multipart/form-data">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Judul Buku:</label>
                <input type="text" id="title" name="title" class="mt-1 p-2 w-full border rounded-lg" placeholder="Masukkan judul buku" required>
            </div>
            <div class="mb-4">
                <label for="category" class="block text-gray-700">Kategori Buku:</label>
                <select id="category" name="category" class="mt-1 p-2 w-full border rounded-lg" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category['id']); ?>">
                            <?php echo htmlspecialchars($category['category_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700">Deskripsi:</label>
            <textarea id="description" name="description" class="mt-1 p-2 w-full border rounded-lg" placeholder="Masukkan deskripsi buku" rows="4" required></textarea>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="quantity" class="block text-gray-700">Jumlah:</label>
                <input type="number" id="quantity" name="quantity" class="mt-1 p-2 w-full border rounded-lg" placeholder="Masukkan jumlah buku" required>
            </div>
            <div class="mb-4">
                <label for="book_file" class="block text-gray-700">Unggah File Buku (PDF):</label>
                <input type="file" id="book_file" name="book_file" class="mt-1 p-2 w-full border rounded-lg" accept=".pdf">
            </div>
        </div>
        <div class="mb-4">
            <label for="cover_image" class="block text-gray-700">Unggah Cover Buku (JPEG/JPG/PNG):</label>
            <input type="file" id="cover_image" name="cover_image" class="mt-1 p-2 w-full border rounded-lg" accept=".jpeg,.jpg,.png">
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Tambah Buku</button>
    </form>
</main>

<?php
require 'footer.php';
?>