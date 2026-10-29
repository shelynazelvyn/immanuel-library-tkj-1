<?php
require_once __DIR__ . "/../config/database.php"; // Memanggil file koneksi database.

function getCategories()
{
    global $pdo; // Menggunakan koneksi database.

    $query = "select * from categories"; // Mengambil semua data kategori.
    $stmt = $pdo->prepare($query); // Menyiapkan query.
    $stmt->execute(); // Menjalankan query.

    $categories = $stmt->fetchAll(); // Mengambil semua data kategori dari database.

    return $categories; // Mengembalikan data kategori.
}

function getCategory()
{
    $category = [
        "id" => 1,
        "name" => "Fiksi",
        "description" => "Novel dan cerita rekaan",
    ]; // Menyimpan contoh data satu kategori.

    return $category; // Mengembalikan data kategori.
}


function isCategoryExists($categoryId)
{
    global $pdo;

    $query = "select count(id) from categories where id = :category_id";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'category_id' => $categoryId
    ]);

    $categoryExists = $stmt->fetchColumn() > 0;

    return $categoryExists;
}


?>
