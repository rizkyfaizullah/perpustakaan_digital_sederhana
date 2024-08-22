<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit;
}

require '../includes/db.php';
require 'pagination.php';

// Pengaturan pagination
$itemsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

// Filter kategori
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';

// Ambil kategori untuk dropdown
$categoryQuery = $pdo->query("SELECT id, category_name FROM categories");
$categories = $categoryQuery->fetchAll(PDO::FETCH_ASSOC);

// Ambil buku dengan nama kategori menggunakan pagination dan filter
$queryStr = "
    SELECT books.id, books.title, books.description, books.quantity, books.book_file, books.cover_image, categories.category_name
    FROM books
    JOIN categories ON books.category_id = categories.id
    WHERE (:selectedCategory = '' OR books.category_id = :selectedCategory)
    ORDER BY books.id ASC
    LIMIT :limit OFFSET :offset
";
$query = $pdo->prepare($queryStr);
$query->bindParam(':selectedCategory', $selectedCategory, PDO::PARAM_INT);
$query->bindParam(':limit', $itemsPerPage, PDO::PARAM_INT);
$query->bindParam(':offset', $offset, PDO::PARAM_INT);
$query->execute();
$books = $query->fetchAll(PDO::FETCH_ASSOC);

// Hitung total buku untuk pagination
$countQueryStr = "
    SELECT COUNT(*) as total
    FROM books
    WHERE (:selectedCategory = '' OR books.category_id = :selectedCategory)
";
$countQuery = $pdo->prepare($countQueryStr);
$countQuery->bindParam(':selectedCategory', $selectedCategory, PDO::PARAM_INT);
$countQuery->execute();
$totalBooks = $countQuery->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalBooks / $itemsPerPage);

require 'header_user.php';
?>

<div class="flex justify-between items-center mb-4">
    <h1 class="text-3xl font-bold">Data Buku</h1>
</div>

<!-- Form untuk filter kategori -->
<div class="flex justify-between items-center mb-4">
    <form action="data_buku.php" method="GET" class="flex items-center">
        <label for="category" class="mr-2 text-gray-700">Filter Kategori:</label>
        <select id="category" name="category" class="p-2 border rounded-lg mr-4">
            <option value="">Semua Kategori</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php echo $selectedCategory == $category['id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category['category_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Terapkan</button>
    </form>
    <a href="create_book_user.php" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Tambah Buku</a>
</div>

<!-- Menampilkan buku yang sudah ada -->
<div class="mt-8">
    <table class="w-full bg-white border border-gray-300 rounded-lg">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-4 border-b">Nomor</th>
                <th class="p-4 border-b">Judul Buku</th>
                <th class="p-4 border-b">Kategori</th>
                <th class="p-4 border-b">Deskripsi</th>
                <th class="p-4 border-b">Jumlah</th>
                <th class="p-4 border-b">PDF</th>
                <th class="p-4 border-b">Cover Buku</th>
                <th class="p-4 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = $offset + 1; ?>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td class="p-4 border-b text-center"><?php echo $nomor++; ?></td>
                    <td class="p-4 border-b"><?php echo htmlspecialchars($book['title']); ?></td>
                    <td class="p-4 border-b"><?php echo htmlspecialchars($book['category_name']); ?></td>
                    <td class="p-4 border-b"><?php echo htmlspecialchars($book['description']); ?></td>
                    <td class="p-4 border-b"><?php echo htmlspecialchars($book['quantity']); ?></td>
                    <td class="p-4 border-b text-center">
                        <?php if ($book['book_file']): ?>
                            <a href="uploads/<?php echo htmlspecialchars($book['book_file']); ?>" class="text-blue-500 hover:underline">Lihat File</a>
                        <?php else: ?>
                            Tidak ada file
                        <?php endif; ?>
                    </td>
                    <td class="p-4 border-b text-center">
                        <?php if ($book['cover_image']): ?>
                            <img src="uploads/<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Cover Buku" class="w-16 h-16 object-cover">
                        <?php else: ?>
                            Tidak ada cover
                        <?php endif; ?>
                    </td>
                    <td class="p-4 border-b text-center">
                        <a href="edit_book_user.php?id=<?php echo $book['id']; ?>" class="text-blue-500 hover:underline">Edit</a>
                        <a href="delete_book_user.php?id=<?php echo $book['id']; ?>" class="text-red-500 hover:underline ml-2" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">Hapus</a>
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