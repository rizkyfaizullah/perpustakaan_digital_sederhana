<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require '../includes/db.php';
require 'pagination.php';

// Pengaturan pagination
$itemsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

// Ambil kategori buku dengan pagination
$query = $pdo->prepare("
    SELECT categories.id, categories.category_name, COUNT(books.id) as book_count
    FROM categories
    LEFT JOIN books ON categories.id = books.category_id
    GROUP BY categories.id
    ORDER BY categories.id ASC
    LIMIT :limit OFFSET :offset
");
$query->bindParam(':limit', $itemsPerPage, PDO::PARAM_INT);
$query->bindParam(':offset', $offset, PDO::PARAM_INT);
$query->execute();
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

// Hitung total kategori untuk pagination
$countQuery = $pdo->query("SELECT COUNT(*) as total FROM categories");
$totalCategories = $countQuery->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalCategories / $itemsPerPage);

require 'header_admin.php';
?>

<div class="flex justify-between items-center mb-4">
    <h1 class="text-3xl font-bold">Data Kategori Buku</h1>
    <a href="create_category.php" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Tambah Kategori</a>
</div>

<!-- Menampilkan kategori yang sudah ada -->
<div class="mt-8">
    <table class="w-full bg-white border border-gray-300 rounded-lg">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-4 border-b">Nomor</th>
                <th class="p-4 border-b">Nama Kategori</th>
                <th class="p-4 border-b">Jumlah Buku</th>
                <th class="p-4 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = $offset + 1; ?>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td class="p-4 border-b text-center"><?php echo $nomor++; ?></td>
                    <td class="p-4 border-b"><?php echo htmlspecialchars($category['category_name']); ?></td>
                    <td class="p-4 border-b text-center"><?php echo htmlspecialchars($category['book_count']); ?></td>
                    <td class="p-4 border-b text-center">
                        <a href="edit_category.php?id=<?php echo $category['id']; ?>" class="text-blue-500 hover:underline">Edit</a>
                        <a href="delete_category.php?id=<?php echo $category['id']; ?>" class="text-red-500 hover:underline ml-2" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php echo getPaginationControls($page, $totalPages); ?>
</div>

<?php
require 'footer.php';
?>