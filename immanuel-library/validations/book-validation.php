<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../repositories/category-repository.php";
require_once __DIR__ . "/../repositories/book-repository.php";
require_once __DIR__ . "/../repositories/author-repository.php";
function getBookRequest($request)
{
    return [
        'id' => trim(htmlspecialchars($request['id'])),
        'title' => trim(htmlspecialchars($request['title'])),
        'isbn' => trim(htmlspecialchars($request['isbn'])),
        'year' => trim(htmlspecialchars($request['year'])),
        'stock' => trim(htmlspecialchars($request['stock'])),
        'description' => trim(htmlspecialchars($request['description'])),
        'category_id' => trim(htmlspecialchars($request['category_id'])),
        'author_ids' => $request['author_ids'] ?? [],
    ];
}

function validateBook($request, $ignoreBookId = 0)
{
    $errors = [];

    // Validasi judul buku.
    if ($request['title'] === '') {
        $errors['title'] = "Judul buku wajib diisi";
    } elseif (mb_strlen($request['title']) > 100) {
        $errors['title'] = "Judul buku tidak boleh melebihi 100 karakter";
    }

    // Validasi ISBN.
    if ($request['isbn'] === '') {
        $errors['isbn'] = "ISBN wajib diisi";
    } elseif (isIsbnTaken($request['isbn'], $ignoreBookId)) {
        $errors['isbn'] = "ISBN sudah terdaftar sebelumnya";
    }

    // Validasi tahun terbit.
    if ($request['year'] === '') {
        $errors['year'] = "Tahun terbit wajib diisi";
    } elseif (!is_numeric($request['year'])) {
        $errors['year'] = "Tahun terbit harus berupa angka";
    }

    // Validasi stok.
    if ($request['stock'] === '') {
        $errors['stock'] = "Stok wajib diisi";
    } elseif (!is_numeric($request['stock']) || (int) $request['stock'] < 0) {
        $errors['stock'] = "Stok wajib diisi berupa angka";
    }

    // Validasi kategori.
    if ($request['category_id'] === '') {
        $errors['category_id'] = "Kategori wajib dipilih";
    } elseif (!isCategoryExists($request['category_id'])) {
        $errors['category_id'] = "Kategori yang dipilih tidak valid";
    }

    // Validate description: required, max 200 character
    if ($request['description'] === '') {
        $errors['description'] = "Deskripsi wajib diisi";
    } elseif (mb_strlen($request['description']) > 200) {
        $errors['description'] = "Deskripsi tidak boleh melebihi 200 karakter";
    }

    // Validate Authors: required, isExists
    if (count($request['author_ids']) < 1) {
        $errors['author_ids'] = "Penulis buku wajib dipilih";
    } else {
        $authors = getAuthors();
        $validAuthorIds = array_column($authors, 'id');

        foreach ($request['author_ids'] as $authorId) {
            if (!in_array($authorId, $validAuthorIds)) {
                $errors['author_ids'] = "Ada penulis buku yang dipilih tidak valid";
            }
        }
    }

    return $errors;
}

function isIsbnTaken($isbn, $ignoreBookId = 0)
{
    global $pdo;

    $bookId = intval($_POST['id'] ?? 0);

    $query = "select count(id) from books where isbn = :isbn and id != :id";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'isbn' => $isbn,
        'id' => $ignoreBookId
    ]);

    return $stmt->fetchColumn() > 0;
}
?>