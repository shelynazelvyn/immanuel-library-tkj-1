```php
<?php
session_start();

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../validations/book-validation.php";
require_once __DIR__ . "/../../repositories/book-repository.php";

$request = getBookRequest($_POST);
$errors = validateBook($request);

if (!empty($errors)) {
    $_SESSION["errors"] = $errors;
    $_SESSION["old"] = $_POST;

    header("Location: ../../pages/books/create.php");
    exit;
}

try {
    $pdo->beginTransaction();

    $query = "insert into books
              (title, isbn, year, stock, description, category_id)
              values
              (:title, :isbn, :year, :stock, :description, :category_id)";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        "title" => $request["title"],
        "isbn" => $request["isbn"],
        "year" => $request["year"],
        "stock" => $request["stock"],
        "description" => $request["description"],
        "category_id" => $request["category_id"]
    ]);

    $bookId = $pdo->lastInsertId();

    foreach ($request["author_ids"] as $authorId) {
        $query = "insert into book_author (book_id, author_id)
                  values (:book_id, :author_id)";

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            "book_id" => $bookId,
            "author_id" => $authorId
        ]);
    }

    $pdo->commit();

    header("Location: ../../pages/books/index.php");
    exit;

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    die("Gagal menyimpan buku: " . $e->getMessage());
}
?>
```