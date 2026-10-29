<?php
session_start();

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../validations/book-validation.php";

if (isset($_POST['update']) && $_SERVER['REQUEST_METHOD'] === "POST") {

    $id = $_POST['id'] ?? 0;

    $request = getBookRequest($_POST);
    $errors = validateBook($request, $id);

    if (!empty($errors)) {
        $_SESSION["errors"] = $errors;
        $_SESSION["old"] = $_POST;

        header("Location: ../../pages/books/edit.php?id=" . urlencode($request["id"]));
        exit;
    }

    try {
        $pdo->beginTransaction();

        $query = "update books set title = :title, isbn = :isbn,
                  year = :year, stock = :stock, category_id = :category_id,
                  description = :description where id = :id";

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'title' => $request["title"],
            'isbn' => $request["isbn"],
            'year' => $request["year"],
            'stock' => $request["stock"],
            'category_id' => $request["category_id"],
            'description' => $request["description"],
            'id' => $id,
        ]);

        $query = "delete from book_author where book_id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            "id" => $id
        ]);

        $query = "insert into book_author (book_id, author_id) values (:book_id, :author_id)";
        $stmt = $pdo->prepare($query);

        $authorIds = isset($request['author_ids']) ? $request['author_ids'] : [];

        foreach ($authorIds as $authorId) {

            $stmt->execute([
                'book_id' => $id,
                'author_id' => htmlspecialchars