<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require '../includes/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    
    // Ambil data buku yang ada untuk referensi
    $stmt = $pdo->prepare("SELECT book_file, cover_image FROM books WHERE id = ?");
    $stmt->execute([$id]);
    $existingBook = $stmt->fetch();

    // Ambil nama file dan gambar jika ada yang baru diunggah
    $book_file = $_FILES['book_file']['name'] ? $_FILES['book_file']['name'] : $existingBook['book_file'];
    $cover_image = $_FILES['cover_image']['name'] ? $_FILES['cover_image']['name'] : $existingBook['cover_image'];

    // Cek dan upload file jika ada
    if ($_FILES['book_file']['name']) {
        move_uploaded_file($_FILES['book_file']['tmp_name'], "../uploads/" . $book_file);
    }
    if ($_FILES['cover_image']['name']) {
        move_uploaded_file($_FILES['cover_image']['tmp_name'], "../uploads/" . $cover_image);
    }

    // Update data buku di database
    $stmt = $pdo->prepare("UPDATE books SET title = ?, category_id = ?, description = ?, quantity = ?, book_file = ?, cover_image = ? WHERE id = ?");
    $stmt->execute([$title, $category_id, $description, $quantity, $book_file, $cover_image, $id]);

    header('Location: data_buku.php');
    exit;
}

// Ambil data buku untuk diedit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->execute([$id]);
    $book = $stmt->fetch();
} else {
    header('Location: data_buku.php');
    exit;
}

require 'header_admin.php';
?>

<main class="container mx-auto p-4 flex-grow">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">Edit Buku</h1>
        <a href="data_buku.php" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600">Kembali</a>
    </div>

    <!-- Form untuk mengedit buku -->
    <form action="edit_book.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($book['id']); ?>">
        <div class="mb-4">
            <label for="title" class="block text-gray-700">Judul Buku:</label>
            <input type="text" id="title" name="title" class="mt-1 p-2 w-full border rounded-lg" value="<?php echo htmlspecialchars($book['title']); ?>" required>
        </div>
        <div class="mb-4">
            <label for="category_id" class="block text-gray-700">Kategori Buku:</label>
            <select id="category_id" name="category_id" class="mt-1 p-2 w-full border rounded-lg" required>
                <?php
                $stmt = $pdo->query("SELECT * FROM categories");
                while ($category = $stmt->fetch()) {
                    $selected = ($category['id'] == $book['category_id']) ? 'selected' : '';
                    echo "<option value='{$category['id']}' $selected>{$category['category_name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700">Deskripsi:</label>
            <textarea id="description" name="description" class="mt-1 p-2 w-full border rounded-lg" rows="4" required><?php echo htmlspecialchars($book['description']); ?></textarea>
        </div>
        <div class="mb-4">
            <label for="quantity" class="block text-gray-700">Jumlah:</label>
            <input type="number" id="quantity" name="quantity" class="mt-1 p-2 w-full border rounded-lg" value="<?php echo htmlspecialchars($book['quantity']); ?>" required>
        </div>
        <div class="mb-4">
            <label for="book_file" class="block text-gray-700">Unggah File Buku (PDF):</label>
            <input type="file" id="book_file" name="book_file" class="mt-1 p-2 w-full border rounded-lg" accept=".pdf">
        </div>
        <div class="mb-4">
            <label for="cover_image" class="block text-gray-700">Unggah Cover Buku (JPEG/JPG/PNG):</label>
            <input type="file" id="cover_image" name="cover_image" class="mt-1 p-2 w-full border rounded-lg" accept=".jpeg,.jpg,.png">
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Perbarui Buku</button>
    </form>
</main>

<?php
require 'footer.php';
?>