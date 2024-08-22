<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <nav class="bg-blue-800 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <a href="home_admin.php" class="text-2xl font-bold">Admin Dashboard</a>
            <div>
                <a href="home_admin.php" class="px-4 py-2 hover:bg-blue-700">Beranda</a>
                <a href="manage_users.php" class="px-4 py-2 hover:bg-blue-700">Kelola Pengguna</a>
                <a href="kategori_buku.php" class="px-4 py-2 hover:bg-blue-700">Kategori Buku</a>
                <a href="data_buku.php" class="px-4 py-2 hover:bg-blue-700">Data Buku</a>
                <a href="logout.php" class="px-4 py-2 hover:bg-blue-700">Keluar</a>
            </div>
        </div>
    </nav>
    <main class="container mx-auto p-4 flex-grow">
        <div class="bg-white shadow-md rounded-lg p-6">